<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ListingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminNotification;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AdminOffMarketListingController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            // new Middleware('document.approved', only: ['create', 'store']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = \App\Models\OffMarketListing::with(['user', 'propertyType', 'unitType']);

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
        return view('admin.off_market_listings.index', compact('users', 'propertyTypes', 'unitTypes', 'features', 'ownershipStatuses', 'rentFrequencies', 'cheques'));
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
        return view('admin.off_market_listings.drafts', compact('users', 'propertyTypes', 'unitTypes', 'features', 'ownershipStatuses', 'rentFrequencies', 'cheques'));
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
        return view('admin.off_market_listings.form', compact('users', 'propertyTypes', 'unitTypes', 'features', 'ownershipStatuses', 'rentFrequencies', 'cheques'));
    }

    public function edit(string $id)
    {
        $listing = \App\Models\OffMarketListing::with(['materialInfo', 'utilities', 'details', 'media', 'features'])->findOrFail($id);
        $users = \App\Models\User::all();
        $propertyTypes = \App\Models\PropertyType::all();
        $unitTypes = \App\Models\UnitType::all();
        $features = \App\Models\Feature::all();
        $ownershipStatuses = \App\Models\OwnershipStatus::all();
        $rentFrequencies = \App\Models\RentFrequency::all();
        $cheques = \App\Models\Cheque::all();
        return view('admin.off_market_listings.form', compact('listing', 'users', 'propertyTypes', 'unitTypes', 'features', 'ownershipStatuses', 'rentFrequencies', 'cheques'));
    }

    public function show(string $id)
    {
        $listing = \App\Models\OffMarketListing::with(['user', 'propertyType', 'unitType', 'features', 'materialInfo', 'utilities', 'media', 'rooms', 'details'])->findOrFail($id);

        // Role-based access control
        $user = auth()->user();
        if (!$user->hasAnyRole(['admin', 'manager', 'listing director', 'Q/A'])) {
            if ($user->hasRole('Agency') || ($user->hasRole('agent') && $user->agency_id)) {
                $ownerId = $user->hasRole('Agency') ? $user->id : $user->agency_id;
                $teamIds = \App\Models\User::where('agency_id', $ownerId)->pluck('id')->toArray();
                $poolIds = array_merge([$ownerId], $teamIds);

                if (!in_array($listing->user_id, $poolIds)) {
                    abort(403, 'Unauthorized access to this listing');
                }
            } else {
                if ($listing->user_id != $user->id) {
                    abort(403, 'Unauthorized access to this listing');
                }
            }
        }

        return view('admin.off_market_listings.show', compact('listing'));
    }

    public function store(ListingRequest $request)
    {
        $validated = $request->validated();

        $validated['property_reference_number'] = $request->property_reference_number ?: 'OFF-REF-' . strtoupper(\Illuminate\Support\Str::random(10));
        $validated['slug'] = \Illuminate\Support\Str::slug($validated['property_title']) . '-' . time();
        $validated['user_id'] = auth()->id();
        $validated['status'] = $request->is_draft ? 'draft' : 'pending';

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }
        if ($request->hasFile('video')) {
            $validated['video'] = $request->file('video')->store('videos', 'public');
        }
        if ($request->hasFile('brochure_pdf')) {
            $validated['brochure_pdf'] = $request->file('brochure_pdf')->store('brochures', 'public');
        }
        if ($request->hasFile('epc_upload')) {
            $validated['epc_upload'] = $request->file('epc_upload')->store('epc', 'public');
        }

        // Separate main table data
        $mainData = \Illuminate\Support\Arr::only($validated, [
            'property_title',
            'summary_description',
            'description',
            'purpose',
            'price',
            'price_qualifier',
            'old_price',
            'postcode',
            'address',
            'display_address',
            'latitude',
            'longitude',
            'bedrooms',
            'bathrooms',
            'reception_rooms',
            'area_size',
            'floor_level',
            'property_type_id',
            'sub_type',
            'unit_type_id',
            'property_reference_number',
            'slug',
            'user_id',
            'status',
            'thumbnail',
            'video',
            'brochure_pdf',
            'epc_upload',
            'virtual_tour_url',
            // Flat fields
            'tenure',
            'unexpired_years',
            'ground_rent',
            'service_charge',
            'council_tax_band',
            'parking_type',
            'parking_spaces_count',
            'construction_type',
            'accessibility',
            'rights_restrictions',
            'listed_building',
            'flood_risk',
            'cladding_risk',
            'other_risks',
            'utilities_water',
            'utilities_electricity',
            'utilities_sewerage',
            'heating_type',
            'broadband',
            'mobile_coverage',
            'key_features',
            'tags',
            'government_scheme',
            'deposit',
            'availability_date'
        ]);

        // Map utilities/heating correctly
        $mainData['heating_type'] = $request->utilities_heating;
        $mainData['broadband'] = $request->utilities_broadband;
        $mainData['mobile_coverage'] = $request->utilities_mobile;
        $mainData['listed_property'] = $request->listed_property;

        $listing = \App\Models\OffMarketListing::create($mainData);

        // Sync Features
        if ($request->has('features')) {
            $listing->features()->sync($request->features);
        }

        // Save Normalized Data
        $listing->materialInfo()->create([
            'tenure' => $request->tenure,
            'unexpired_years' => $request->unexpired_years,
            'ground_rent' => $request->ground_rent,
            'service_charge' => $request->service_charge,
            'council_tax_band' => $request->council_tax_band,
            'parking_type' => $request->parking_type,
            'parking_spaces_count' => $request->parking_spaces_count,
            'construction_type' => $request->construction_type,
            'accessibility' => $request->accessibility,
            'rights_restrictions' => $request->rights_restrictions,
            'listed_building' => $request->listed_property, // Fixed: Front-end uses listed_property
            'flood_risk' => $request->flood_risk,
            'cladding_risk' => $request->cladding_risk,
            'other_risks' => $request->other_risks,
        ]);

        // Notify Admin
        Mail::to('info@propertyfinda.co.uk')->send(new AdminNotification('listing_added', [
            'user' => auth()->user(),
            'listing' => $listing,
            'listing_type' => 'Off-Market Listing'
        ]));

        $listing->utilities()->create([
            'water' => $request->utilities_water,
            'electricity' => $request->utilities_electricity,
            'sewerage' => $request->utilities_sewerage,
            'heating_type' => $request->utilities_heating,
            'broadband' => $request->utilities_broadband,
            'mobile_coverage' => $request->utilities_mobile,
        ]);

        $listing->details()->create([
            'key_features' => $request->key_features,
            'tags' => $request->tags,
            'government_scheme' => $request->government_scheme,
            'deposit' => $request->deposit,
        ]);

        // Media Uploads
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                $listing->media()->create([
                    'type' => 'photo',
                    'file_path' => $file->store('gallery', 'public'),
                ]);
            }
        }

        if ($request->hasFile('floor_plans')) {
            foreach ($request->file('floor_plans') as $file) {
                $listing->media()->create([
                    'type' => 'floorplan',
                    'file_path' => $file->store('floor_plans', 'public'),
                ]);
            }
        }

        $this->updateListingLifeCycle($listing);

        return response()->json(['success' => true, 'message' => 'Off-Market Listing created successfully.', 'listing_id' => $listing->id]);

        return response()->json(['success' => true, 'message' => 'Off-Market Listing created successfully.', 'listing_id' => $listing->id]);
    }

    public function update(ListingRequest $request, string $id)
    {
        $listing = \App\Models\OffMarketListing::findOrFail($id);

        $validated = $request->validated();

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }
        if ($request->hasFile('video')) {
            $validated['video'] = $request->file('video')->store('videos', 'public');
        }
        if ($request->hasFile('brochure_pdf')) {
            $validated['brochure_pdf'] = $request->file('brochure_pdf')->store('brochures', 'public');
        }
        if ($request->hasFile('epc_upload')) {
            $validated['epc_upload'] = $request->file('epc_upload')->store('epc', 'public');
        }

        if ($request->is_draft) {
            $validated['status'] = 'draft';
        }

        // Separate main table data
        $mainData = \Illuminate\Support\Arr::only($validated, [
            'property_title',
            'summary_description',
            'description',
            'purpose',
            'price',
            'price_qualifier',
            'old_price',
            'postcode',
            'address',
            'display_address',
            'latitude',
            'longitude',
            'bedrooms',
            'bathrooms',
            'reception_rooms',
            'area_size',
            'floor_level',
            'property_type_id',
            'sub_type',
            'unit_type_id',
            'status',
            'thumbnail',
            'video',
            'brochure_pdf',
            'epc_upload',
            'virtual_tour_url',
            // Flat fields
            'tenure',
            'unexpired_years',
            'ground_rent',
            'service_charge',
            'council_tax_band',
            'parking_type',
            'parking_spaces_count',
            'construction_type',
            'accessibility',
            'rights_restrictions',
            'listed_building',
            'flood_risk',
            'cladding_risk',
            'other_risks',
            'utilities_water',
            'utilities_electricity',
            'utilities_sewerage',
            'heating_type',
            'broadband',
            'mobile_coverage',
            'key_features',
            'tags',
            'government_scheme',
            'deposit',
            'availability_date'
        ]);

        // Map utilities/heating correctly
        $mainData['heating_type'] = $request->utilities_heating;
        $mainData['broadband'] = $request->utilities_broadband;
        $mainData['mobile_coverage'] = $request->utilities_mobile;
        $mainData['listed_property'] = $request->listed_property;

        $listing->update($mainData);

        // Sync Features
        if ($request->has('features')) {
            $listing->features()->sync($request->features);
        }

        // Update Normalized Data
        $listing->materialInfo()->updateOrCreate([], [
            'tenure' => $request->tenure,
            'unexpired_years' => $request->unexpired_years,
            'ground_rent' => $request->ground_rent,
            'service_charge' => $request->service_charge,
            'council_tax_band' => $request->council_tax_band,
            'parking_type' => $request->parking_type,
            'parking_spaces_count' => $request->parking_spaces_count,
            'construction_type' => $request->construction_type,
            'accessibility' => $request->accessibility,
            'rights_restrictions' => $request->rights_restrictions,
            'listed_building' => $request->listed_property, // Fixed: Front-end uses listed_property
            'flood_risk' => $request->flood_risk,
            'cladding_risk' => $request->cladding_risk,
            'other_risks' => $request->other_risks,
        ]);

        $listing->utilities()->updateOrCreate([], [
            'water' => $request->utilities_water,
            'electricity' => $request->utilities_electricity,
            'sewerage' => $request->utilities_sewerage,
            'heating_type' => $request->utilities_heating,
            'broadband' => $request->utilities_broadband,
            'mobile_coverage' => $request->utilities_mobile,
        ]);

        $listing->details()->updateOrCreate([], [
            'key_features' => $request->key_features,
            'tags' => $request->tags,
            'government_scheme' => $request->government_scheme,
            'deposit' => $request->deposit,
        ]);

        // Media Uploads
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                $listing->media()->create([
                    'type' => 'photo',
                    'file_path' => $file->store('gallery', 'public'),
                ]);
            }
        }

        if ($request->hasFile('floor_plans')) {
            foreach ($request->file('floor_plans') as $file) {
                $listing->media()->create([
                    'type' => 'floorplan',
                    'file_path' => $file->store('floor_plans', 'public'),
                ]);
            }
        }

        // Remove media logic
        if ($request->has('remove_media')) {
            \App\Models\OffMarketMedia::whereIn('id', $request->remove_media)->delete();
        }

        $this->updateListingLifeCycle($listing);

        return response()->json(['success' => true, 'message' => 'Off-Market Listing updated successfully.']);
    }

    private function updateListingLifeCycle($listing)
    {
        if ($listing->status === 'draft') {
            return;
        }

        // Removed auto-approval so newly added listings stay 'pending' by default.
    }

    public function destroy(string $id)
    {
        $listing = \App\Models\OffMarketListing::findOrFail($id);
        $listing->delete();

        return response()->json(['success' => true, 'message' => 'Off-Market Listing deleted successfully.']);
    }

    public function updateStatus(Request $request, $id)
    {
        $listing = \App\Models\OffMarketListing::findOrFail($id);
        $newStatus = $request->status;

        // If trying to set to approved, under_offer, or sold, check if listing owner is verified
        $restrictedStatuses = ['approved', 'under_offer', 'sold'];
        if (in_array($newStatus, $restrictedStatuses) && $listing->user->status !== 'document_approved') {
            return response()->json([
                'success' => false,
                'message' => 'Verification Required: You must verify your account before setting this listing to ' . str_replace('_', ' ', $newStatus) . '.',
                'redirect' => route('profile.edit')
            ], 403);
        }

        $listing->update(['status' => $newStatus]);
        return response()->json(['success' => true, 'message' => 'Status updated to ' . str_replace('_', ' ', $newStatus)]);
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
                // Filter IDs where owners are verified
                $validIds = \App\Models\OffMarketListing::whereIn('id', $ids)
                    ->whereHas('user', function ($q) {
                        $q->where('status', 'document_approved');
                    })->pluck('id')->toArray();

                $invalidCount = count($ids) - count($validIds);

                if (empty($validIds)) {
                    return response()->json(['success' => false, 'message' => 'None of the selected deals can be approved because their owners are not verified.'], 403);
                }

                \App\Models\OffMarketListing::whereIn('id', $validIds)->update(['status' => 'approved']);
                $msg = count($validIds) . " deals approved.";
                if ($invalidCount > 0)
                    $msg .= " ($invalidCount skipped due to unverified owners)";
                break;
            case 'pending':
            case 'rejected':
                \App\Models\OffMarketListing::whereIn('id', $ids)->update(['status' => $action]);
                $msg = "Selected deals marked as " . $action;
                break;
            case 'delete':
                \App\Models\OffMarketListing::whereIn('id', $ids)->delete();
                $msg = "Selected deals deleted successfully.";
                break;
            case 'draft':
                \App\Models\OffMarketListing::whereIn('id', $ids)->update(['status' => 'draft']);
                $msg = "Selected deals moved to drafts.";
                break;
            case 'duplicate':
                foreach ($ids as $id) {
                    $original = \App\Models\OffMarketListing::with(['features', 'materialInfo', 'utilities', 'details', 'media'])->find($id);
                    if ($original) {
                        $new = $original->replicate();
                        $new->property_title = $original->property_title . ' (Copy)';
                        $new->slug = \Illuminate\Support\Str::slug($new->property_title) . '-' . time() . '-' . uniqid();
                        $new->property_reference_number = 'OFF-REF-' . time() . strtoupper(\Illuminate\Support\Str::random(5));
                        $new->status = 'pending';
                        $new->created_at = now();
                        $new->updated_at = now();
                        $new->save();

                        // Sync features
                        if ($original->features->isNotEmpty()) {
                            $new->features()->sync($original->features->pluck('id'));
                        }

                        // Replicate associated records
                        if ($original->materialInfo)
                            $new->materialInfo()->create($original->materialInfo->toArray());
                        if ($original->utilities)
                            $new->utilities()->create($original->utilities->toArray());
                        if ($original->details)
                            $new->details()->create($original->details->toArray());

                        // Replicate media records
                        foreach ($original->media as $media) {
                            $new->media()->create([
                                'type' => $media->type,
                                'file_path' => $media->file_path,
                                'sort_order' => $media->sort_order
                            ]);
                        }
                    }
                }
                $msg = count($ids) . " deals duplicated successfully.";
                break;
            case 'export':
                return response()->json(['success' => true, 'redirect' => route('admin.off-market-listings.export', ['ids' => implode(',', $ids)])]);
            default:
                return response()->json(['success' => false, 'message' => 'Invalid action.'], 422);
        }

        return response()->json(['success' => true, 'message' => $msg]);
    }

    public function export(Request $request)
    {
        $ids = $request->ids ? explode(',', $request->ids) : null;

        $query = \App\Models\OffMarketListing::with(['user', 'propertyType', 'unitType', 'features', 'ownershipStatus', 'rentFrequency', 'cheque']);

        if ($ids) {
            $query->whereIn('id', $ids);
        }

        $listings = $query->get();
        $filename = "off_market_listings_export_" . date('Y-m-d_H-i-s') . ".csv";

        $handle = fopen('php://memory', 'w');

        // CSV Header
        fputcsv($handle, [
            'ID',
            'Title',
            'Reference',
            'Purpose',
            'Price',
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
