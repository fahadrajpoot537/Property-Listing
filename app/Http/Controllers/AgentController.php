<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AgentController extends Controller
{
    public function index(Request $request)
    {
        $query = User::role('agent')
            ->where('status', 'approved')
            ->with([
                'listings' => function ($q) {
                    $q->where('status', 'approved')->take(3);
                }
            ]);

        // Location-based search
        if ($request->filled(['latitude', 'longitude', 'radius'])) {
            $lat = $request->latitude;
            $lng = $request->longitude;
            $radius = $request->radius; // in miles

            // Haversine formula to calculate distance
            $query->select('users.*')
                ->selectRaw(
                    '( 3959 * acos( cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude ) ) ) ) AS distance',
                    [$lat, $lng, $lat]
                )
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->having('distance', '<=', $radius)
                ->orderBy('distance', 'asc');
        } else {
            // Default ordering
            $query->orderBy('created_at', 'desc');
        }

        $agents = $query->paginate(12);

        return view('agents.index', compact('agents'));
    }
}
