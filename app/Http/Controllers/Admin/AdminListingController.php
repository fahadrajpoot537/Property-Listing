<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AdminListingController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('document.approved', only: ['create', 'store']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = \App\Models\Listing::with(['user', 'propertyType', 'unitType', 'features']);

            // Role-based filtering
            $user = auth()->user();
            if (!$user->hasAnyRole(['admin', 'manager', 'listing director', 'Q/A'])) {
                if ($user->hasRole('Agency') || ($user->hasRole('agent') && $user->agency_id)) {
                    // Determine the Agency Owner ID
                    $ownerId = $user->hasRole('Agency') ? $user->id : $user->agency_id;

                    // Get all team member IDs
                    $teamIds = \App\Models\User::where('agency_id', $ownerId)->pluck('id')->toArray();
                    $poolIds = array_merge([$ownerId], $teamIds);

                    $query->whereIn('user_id', $poolIds);
                } else {
                    // Independent Freelance, Landlords, or Agents without agency see only their own
                    $query->where('user_id', $user->id);
                }
            }

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

            if ($request->get('is_draft')) {
                $query->where('status', 'draft');
            } else {
                $query->where('status', '!=', 'draft');
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

    public function drafts(Request $request)
    {
        if ($request->ajax()) {
            return $this->index($request);
        }
        $users = \App\Models\User::all();
        $propertyTypes = \App\Models\PropertyType::all();
        $unitTypes = \App\Models\UnitType::all();
        $features = \App\Models\Feature::all();
        $ownershipStatuses = \App\Models\OwnershipStatus::all();
        $rentFrequencies = \App\Models\RentFrequency::all();
        $cheques = \App\Models\Cheque::all();
        return view('admin.listings.drafts', compact('users', 'propertyTypes', 'unitTypes', 'features', 'ownershipStatuses', 'rentFrequencies', 'cheques'));
    }

    public function create()
    {
        $users = \App\Models\User::all();
        $propertyTypes = \App\Models\PropertyType::all();
        $unitTypes = \App\Models\UnitType::all();
        $features = \App\Models\Feature::all();
        $ownershipStatuses = \App\Models\OwnershipStatus::all();
        $rentFrequencies = \App\Models\RentFrequency::all();
        $cheques = \App\Models\Cheque::all();
        return view('admin.listings.form', compact('users', 'propertyTypes', 'unitTypes', 'features', 'ownershipStatuses', 'rentFrequencies', 'cheques'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'property_title' => 'required|string|max:255',
            'description' => 'required|string',
            'purpose' => 'required|in:Rent,Buy',
            'price' => 'required|numeric',
            'old_price' => 'nullable|numeric',
            'area_size' => 'required|string',
            'bedrooms' => 'nullable|integer|min:0|max:100',
            'bathrooms' => 'nullable|integer|min:0|max:100',
            'property_type_id' => 'required|exists:property_types,id',
            'unit_type_id' => 'required|exists:unit_types,id',
            'address' => 'nullable|string|max:500',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'video' => 'nullable|file|mimetypes:video/mp4,video/quicktime|max:35840', // Max 35MB
            'features' => 'array',
            'thumbnail' => 'required|image|max:10240', // Max 10MB
            'gallery.*' => 'image|mimes:jpeg,png,jpg,webp|max:20480', // Max 20MB
            'floor_plans.*' => 'image|mimes:jpeg,png,jpg,webp|max:20480', // Max 20MB
            'ownership_status_id' => 'nullable|exists:ownership_statuses,id',
            'rent_frequency_id' => 'nullable|exists:rent_frequencies,id',
            'cheque_id' => 'nullable|exists:cheques,id',
            'council_tax_band' => 'nullable|string',
            'epc_rating' => 'nullable|string',
            'floors_count' => 'nullable|integer',
            'availability_date' => 'nullable|date',
            'no_onward_chain' => 'nullable|boolean',
            'private_rights_of_way' => 'nullable|string',
            'public_rights_of_way' => 'nullable|string',
            'listed_property' => 'nullable|string',
            'restrictions' => 'nullable|string',
            'flood_risk' => 'nullable|string',
            'flood_history' => 'nullable|string',
            'flood_defenses' => 'nullable|string',
            'brochure_pdf' => 'nullable|file|mimes:pdf|max:10240',
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

        if ($request->hasFile('brochure_pdf')) {
            $validated['brochure_pdf'] = $request->file('brochure_pdf')->store('brochures', 'public');
        }

        if ($request->hasFile('floor_plans')) {
            $floorPlanPaths = [];
            foreach ($request->file('floor_plans') as $file) {
                $floorPlanPaths[] = $file->store('floor_plans', 'public');
            }
            $validated['floor_plans'] = $floorPlanPaths;
        }

        $listing = \App\Models\Listing::create($validated);

        if ($request->is_draft == "1") {
            $listing->update(['status' => 'draft']);
        }


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
        $users = \App\Models\User::all();
        $propertyTypes = \App\Models\PropertyType::all();
        $unitTypes = \App\Models\UnitType::all();
        $features = \App\Models\Feature::all();
        $ownershipStatuses = \App\Models\OwnershipStatus::all();
        $rentFrequencies = \App\Models\RentFrequency::all();
        $cheques = \App\Models\Cheque::all();
        return view('admin.listings.form', compact('listing', 'users', 'propertyTypes', 'unitTypes', 'features', 'ownershipStatuses', 'rentFrequencies', 'cheques'));
    }

    public function update(Request $request, string $id)
    {
        $listing = \App\Models\Listing::findOrFail($id);

        $validated = $request->validate([
            'property_title' => 'required|string|max:255',
            'description' => 'required|string',
            'purpose' => 'required|in:Rent,Buy',
            'price' => 'required|numeric',
            'old_price' => 'nullable|numeric',
            'area_size' => 'required|string',
            'bedrooms' => 'nullable|integer|min:0|max:100',
            'bathrooms' => 'nullable|integer|min:0|max:100',
            'property_type_id' => 'required|exists:property_types,id',
            'unit_type_id' => 'required|exists:unit_types,id',
            'address' => 'nullable|string|max:500',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'video' => 'nullable|file|mimetypes:video/mp4,video/quicktime|max:35840', // Max 35MB
            'status' => 'sometimes|in:pending,approved,rejected,draft',
            'features' => 'array',
            'thumbnail' => 'image|nullable|max:10240', // Max 10MB
            'gallery.*' => 'image|mimes:jpeg,png,jpg,webp|max:20480', // Max 20MB
            'floor_plans.*' => 'image|mimes:jpeg,png,jpg,webp|max:20480', // Max 20MB
            'ownership_status_id' => 'nullable|exists:ownership_statuses,id',
            'rent_frequency_id' => 'nullable|exists:rent_frequencies,id',
            'cheque_id' => 'nullable|exists:cheques,id',
            'council_tax_band' => 'nullable|string',
            'epc_rating' => 'nullable|string',
            'floors_count' => 'nullable|integer',
            'availability_date' => 'nullable|date',
            'no_onward_chain' => 'nullable|boolean',
            'private_rights_of_way' => 'nullable|string',
            'public_rights_of_way' => 'nullable|string',
            'listed_property' => 'nullable|string',
            'restrictions' => 'nullable|string',
            'flood_risk' => 'nullable|string',
            'flood_history' => 'nullable|string',
            'flood_defenses' => 'nullable|string',
            'brochure_pdf' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        } elseif ($request->has('remove_thumbnail')) {
            $validated['thumbnail'] = null;
        }

        if ($request->hasFile('video')) {
            $validated['video'] = $request->file('video')->store('videos', 'public');
        } elseif ($request->has('remove_video')) {
            $validated['video'] = null;
        }

        // Keep existing images (minus removed ones)
        $galleryPaths = $listing->gallery ?? [];

        // Remove images marked for deletion
        if ($request->has('remove_gallery')) {
            $galleryPaths = array_diff($galleryPaths, array_filter($request->remove_gallery));
            Log::info('Gallery paths after removal: ', $galleryPaths);
        }

        // Add new uploaded images
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                $galleryPaths[] = $file->store('gallery', 'public');
            }
            Log::info('New gallery paths added: ', $galleryPaths);
        }

        $validated['gallery'] = array_values($galleryPaths);

        if ($request->hasFile('brochure_pdf')) {
            if ($listing->brochure_pdf)
                \Storage::disk('public')->delete($listing->brochure_pdf);
            $validated['brochure_pdf'] = $request->file('brochure_pdf')->store('brochures', 'public');
        }

        // Handle Floor Plans
        $floorPlanPaths = $listing->floor_plans ?? [];

        if ($request->has('remove_floor_plans')) {
            $floorPlanPaths = array_diff($floorPlanPaths, array_filter($request->remove_floor_plans));
        }

        if ($request->hasFile('floor_plans')) {
            foreach ($request->file('floor_plans') as $file) {
                $floorPlanPaths[] = $file->store('floor_plans', 'public');
            }
        }
        $validated['floor_plans'] = array_values($floorPlanPaths);

        $listing->update($validated);

        if ($request->is_draft == "1") {
            $listing->update(['status' => 'draft']);
        }

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
            case 'draft':
                \App\Models\Listing::whereIn('id', $ids)->update(['status' => 'draft']);
                $msg = "Selected listings moved to drafts.";
                break;
            case 'duplicate':
                foreach ($ids as $id) {
                    $original = \App\Models\Listing::with('features')->find($id);
                    if ($original) {
                        $new = $original->replicate();
                        $new->property_title = $original->property_title . ' (Copy)';
                        $new->slug = \Illuminate\Support\Str::slug($new->property_title) . '-' . time() . '-' . uniqid();
                        $new->property_reference_number = 'REF-' . time() . uniqid();
                        $new->status = 'pending';
                        $new->created_at = now();
                        $new->updated_at = now();
                        $new->save();

                        // Sync features
                        if ($original->features->isNotEmpty()) {
                            $new->features()->sync($original->features->pluck('id'));
                        }
                    }
                }
                $msg = "Selected listings duplicated successfully.";
                break;
            case 'export':
                return response()->json(['success' => true, 'redirect' => route('admin.listings.export', ['ids' => implode(',', $ids)])]);
            default:
                return response()->json(['success' => false, 'message' => 'Invalid action.'], 422);
        }

        return response()->json(['success' => true, 'message' => $msg]);
    }

    public function export(Request $request)
    {
        $ids = $request->ids ? explode(',', $request->ids) : null;

        $query = \App\Models\Listing::with(['user', 'propertyType', 'unitType', 'features', 'ownershipStatus', 'rentFrequency', 'cheque']);

        if ($ids) {
            $query->whereIn('id', $ids);
        }

        $listings = $query->get();
        $filename = "listings_export_" . date('Y-m-d_H-i-s') . ".csv";

        $handle = fopen('php://memory', 'w');

        // CSV Header
        fputcsv($handle, [
            'ID',
            'Title',
            'Reference',
            'Purpose',
            'Price',
            'Old Price',
            'Address',
            'Status',
            'Bedrooms',
            'Bathrooms',
            'Area Size',
            'Property Type',
            'Unit Type',
            'Ownership Status',
            'Rent Frequency',
            'Cheque',
            'Availability Date',
            'Council Tax Band',
            'EPC Rating',
            'Description',
            'Created At'
        ]);

        foreach ($listings as $listing) {
            fputcsv($handle, [
                $listing->id,
                $listing->property_title,
                $listing->property_reference_number,
                $listing->purpose,
                $listing->price,
                $listing->old_price,
                $listing->address,
                $listing->status,
                $listing->bedrooms,
                $listing->bathrooms,
                $listing->area_size,
                $listing->propertyType->title ?? '',
                $listing->unitType->title ?? '',
                $listing->ownershipStatus->title ?? '',
                $listing->rentFrequency->title ?? '',
                $listing->cheque->title ?? '',
                $listing->availability_date,
                $listing->council_tax_band,
                $listing->epc_rating,
                strip_tags($listing->description),
                $listing->created_at
            ]);
        }

        fseek($handle, 0);

        return response()->stream(
            function () use ($handle) {
                fpassthru($handle);
                fclose($handle);
            },
            200,
            [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ]
        );
    }
}
