<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminListingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = \App\Models\Listing::with(['user', 'propertyType', 'unitType', 'features']);
            
            // Apply filters if provided
            if ($request->has('filters')) {
                $filters = $request->get('filters');
                
                if (!empty($filters['property_title'])) {
                    $query->where('property_title', 'like', '%' . $filters['property_title'] . '%');
                }
                
                if (!empty($filters['property_type_id'])) {
                    $query->where('property_type_id', $filters['property_type_id']);
                }
                
                if (!empty($filters['purpose'])) {
                    $query->where('purpose', $filters['purpose']);
                }
                
                if (!empty($filters['status'])) {
                    $query->where('status', $filters['status']);
                }
                
                if (!empty($filters['min_price'])) {
                    $query->where('price', '>=', $filters['min_price']);
                }
                
                if (!empty($filters['max_price'])) {
                    $query->where('price', '<=', $filters['max_price']);
                }
                
                if (!empty($filters['bedrooms'])) {
                    $query->where('bedrooms', '>=', $filters['bedrooms']);
                }
                
                if (!empty($filters['bathrooms'])) {
                    $query->where('bathrooms', '>=', $filters['bathrooms']);
                }
            }
            
            $listings = $query->latest()->get();
            return response()->json(['data' => $listings]);
        }
        $users = \App\Models\User::all();
        $propertyTypes = \App\Models\PropertyType::all();
        $unitTypes = \App\Models\UnitType::all();
        $features = \App\Models\Feature::all();
        $ownershipStatuses = \App\Models\OwnershipStatus::all();
        $rentFrequencies = \App\Models\RentFrequency::all();
        $cheques = \App\Models\Cheque::all();
        return view('admin.listings.index', compact('users', 'propertyTypes', 'unitTypes', 'features', 'ownershipStatuses', 'rentFrequencies', 'cheques'));
    }

    public function create()
    {
        abort(404);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'property_title' => 'required|string|max:255',
            'description' => 'required|string',
            'purpose' => 'required|in:Rent,Buy',
            'price' => 'required|numeric',
            'area_size' => 'required|string',
            'bedrooms' => 'required|integer|min:0|max:100',
            'bathrooms' => 'required|integer|min:0|max:100',
            'property_type_id' => 'required|exists:property_types,id',
            'unit_type_id' => 'required|exists:unit_types,id',
            'address' => 'nullable|string|max:500',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'video' => 'nullable|file|mimetypes:video/mp4,video/quicktime|max:20480', // Max 20MB
            'features' => 'array',
            'thumbnail' => 'required|image|max:2048',
            'gallery.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'ownership_status_id' => 'nullable|exists:ownership_statuses,id',
            'rent_frequency_id' => 'nullable|exists:rent_frequencies,id',
            'cheque_id' => 'nullable|exists:cheques,id',
        ]);

        $validated['property_reference_number'] = 'REF-' . time();
        $validated['slug'] = \Illuminate\Support\Str::slug($validated['property_title']) . '-' . time();
        $validated['status'] = 'pending';
        $validated['user_id'] = auth()->id();

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        if ($request->hasFile('video')) {
            $validated['video'] = $request->file('video')->store('videos', 'public');
        }

        if ($request->hasFile('gallery')) {
            $galleryPaths = [];
            foreach ($request->file('gallery') as $file) {
                $galleryPaths[] = $file->store('gallery', 'public');
            }
            $validated['gallery'] = $galleryPaths;
        }

        $listing = \App\Models\Listing::create($validated);

        if (isset($validated['features'])) {
            $listing->features()->sync($validated['features']);
        }

        return response()->json(['success' => true, 'message' => 'Listing created successfully.']);
    }

    public function show(string $id)
    {
        $listing = \App\Models\Listing::with(['user', 'features', 'propertyType', 'unitType', 'ownershipStatus', 'rentFrequency', 'cheque'])->findOrFail($id);
        return view('admin.listings.show', compact('listing'));
    }

    public function edit(string $id)
    {
        $listing = \App\Models\Listing::with(['features', 'ownershipStatus', 'rentFrequency', 'cheque'])->findOrFail($id);
        return response()->json($listing);
    }

    public function update(Request $request, string $id)
    {
        $listing = \App\Models\Listing::findOrFail($id);

        $validated = $request->validate([
            'property_title' => 'required|string|max:255',
            'description' => 'required|string',
            'purpose' => 'required|in:Rent,Buy',
            'price' => 'required|numeric',
            'area_size' => 'required|string',
            'bedrooms' => 'required|integer|min:0|max:100',
            'bathrooms' => 'required|integer|min:0|max:100',
            'property_type_id' => 'required|exists:property_types,id',
            'unit_type_id' => 'required|exists:unit_types,id',
            'address' => 'nullable|string|max:500',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'video' => 'nullable|file|mimetypes:video/mp4,video/quicktime|max:20480',
            'status' => 'sometimes|in:pending,approved,rejected',
            'features' => 'array',
            'thumbnail' => 'image|nullable|max:2048',
            'gallery.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'ownership_status_id' => 'nullable|exists:ownership_statuses,id',
            'rent_frequency_id' => 'nullable|exists:rent_frequencies,id',
            'cheque_id' => 'nullable|exists:cheques,id',
        ]);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        if ($request->hasFile('video')) {
            $validated['video'] = $request->file('video')->store('videos', 'public');
        }

        // Handle gallery updates - replace existing images with new ones
        $galleryPaths = [];
        
        // Debug: Log remove_gallery data
        if ($request->has('remove_gallery')) {
            Log::info('remove_gallery data: ', $request->remove_gallery);
            Log::info('Original gallery paths: ', $listing->gallery ?? []);
        }
        
        // If new images are uploaded, replace all existing images
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                $galleryPaths[] = $file->store('gallery', 'public');
            }
            Log::info('New gallery paths: ', $galleryPaths);
        } else {
            // If no new images are uploaded, keep existing images (minus removed ones)
            $galleryPaths = $listing->gallery ?? [];
            
            // Remove images marked for deletion
            if ($request->has('remove_gallery')) {
                $galleryPaths = array_diff($galleryPaths, $request->remove_gallery);
                Log::info('Gallery paths after removal: ', $galleryPaths);
            }
        }
        
        $validated['gallery'] = array_values($galleryPaths);

        $listing->update($validated);

        if (isset($validated['features'])) {
            $listing->features()->sync($validated['features']);
        }

        return response()->json(['success' => true, 'message' => 'Listing updated successfully.']);
    }

    public function destroy(string $id)
    {
        $listing = \App\Models\Listing::findOrFail($id);
        $listing->delete();

        return response()->json(['success' => true, 'message' => 'Listing deleted successfully.']);
    }

    public function updateStatus(Request $request, $id)
    {
        $listing = \App\Models\Listing::findOrFail($id);
        $listing->update(['status' => $request->status]);
        return response()->json(['success' => true, 'message' => 'Status updated to ' . $request->status]);
    }

    public function bulkAction(Request $request)
    {
        $ids = $request->ids;
        $action = $request->action;

        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'No items selected.'], 422);
        }

        switch ($action) {
            case 'approved':
            case 'pending':
            case 'rejected':
                \App\Models\Listing::whereIn('id', $ids)->update(['status' => $action]);
                $msg = "Selected listings marked as " . $action;
                break;
            case 'delete':
                \App\Models\Listing::whereIn('id', $ids)->delete();
                $msg = "Selected listings deleted successfully.";
                break;
            default:
                return response()->json(['success' => false, 'message' => 'Invalid action.'], 422);
        }

        return response()->json(['success' => true, 'message' => $msg]);
    }
}
