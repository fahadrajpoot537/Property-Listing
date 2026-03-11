<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Listing;
use App\Models\OffMarketListing;
use App\Models\PropertyType;
use Illuminate\Database\Eloquent\Builder;

class ChatbotController extends Controller
{
    public function chat(Request $request)
    {
        $userMessage = $request->input('message');

        // Quick greeting check (enhanced)
        if (preg_match('/^\s*(hi|hello|hey|greetings|hy|hiya|hola)\b/i', $userMessage)) {
            return response()->json(['reply' => "Hello! 👋 I can help you find properties. Try 'Rent a flat in Edinburgh' or 'Buy a house in London'.", 'results' => []]);
        }

        // Extract Criteria
        $criteria = $this->extractCriteria($userMessage);

        // Check if criteria is effectively empty (prevent "show all" dump)
        if ($this->isCriteriaEmpty($criteria)) {
            return response()->json([
                'reply' => "I didn't catch any specific property details. Could you mention a location, property type, or whether you want to Buy or Rent?",
                'results' => []
            ]);
        }

        // Perform Search
        $results = $this->performSearch($criteria);

        return response()->json([
            'reply' => $this->constructSearchReply($criteria, $results->count()),
            'results' => $results
        ]);
    }

    private function isCriteriaEmpty($criteria)
    {
        return empty($criteria['purpose']) &&
            empty($criteria['property_type_id']) &&
            empty($criteria['bedrooms']) &&
            empty($criteria['min_price']) &&
            empty($criteria['max_price']) &&
            empty($criteria['location']);
    }

    private function extractCriteria($message)
    {
        $message = strtolower($message);
        $criteria = [
            'purpose' => null,
            'property_type_id' => null,
            'bedrooms' => null,
            'min_price' => null,
            'max_price' => null,
            'location' => null
        ];

        // 1. Explicit "Location:" handling (if user pastes structured text)
        if (preg_match('/location:\s*([a-z0-9\s,]+)/i', $message, $matches)) {
            $val = trim(explode('(', $matches[1])[0]); // Remove (comments)
            if (!str_contains($val, 'any') && strlen($val) > 2) {
                $criteria['location'] = trim($val);
            }
        }

        // 2. Purpose
        $hasBuy = str_contains($message, 'buy') || str_contains($message, 'sale');
        $hasRent = str_contains($message, 'rent') || str_contains($message, 'let');

        if ($hasBuy && !$hasRent)
            $criteria['purpose'] = 'Buy';
        if ($hasRent && !$hasBuy)
            $criteria['purpose'] = 'Rent';

        // 3. Unit Type (Strict)
        $aliases = [
            'flat' => 'Apartment',
            'flats' => 'Apartment',
            'apartment' => 'Apartment',
            'house' => 'House',
            'homes' => 'House',
            'villa' => 'Villa',
            'studio' => 'Studio',
            'office' => 'Office',
            'shop' => 'Shop',
            'land' => 'Land'
        ];
        foreach ($aliases as $alias => $title) {
            if (str_contains($message, $alias)) {
                $type = PropertyType::where('title', 'LIKE', '%' . $title . '%')->first();
                if ($type) {
                    $criteria['property_type_id'] = $type->id;
                    break;
                }
            }
        }

        // 4. Bedrooms
        if (preg_match('/bedrooms?:\s*(\d+)/i', $message, $matches)) {
            $criteria['bedrooms'] = (int) $matches[1];
        } elseif (preg_match('/(\d+)\s*(?:bed|br)/i', $message, $matches)) {
            $criteria['bedrooms'] = (int) $matches[1];
        }

        // 5. Location (General)
        if (empty($criteria['location'])) {
            // Postcode
            if (preg_match('/\b([a-z]{1,2}\d{1,2}[a-z]?)\b/i', $message, $matches)) {
                $ignore = ['in', 'at', 'to', 'or', 'is', 'of', 'uk', 'go', 'my', 'me', 'hy', 'hi', 'by', 'ok'];
                if (!in_array($matches[1], $ignore))
                    $criteria['location'] = strtoupper($matches[1]);
            }
            // City Scan
            if (empty($criteria['location'])) {
                $cities = ['London', 'Manchester', 'Birmingham', 'Leeds', 'Glasgow', 'Liverpool', 'Bristol', 'Edinburgh', 'Exeter', 'Cardiff', 'Scotland', 'Wales'];
                foreach ($cities as $city) {
                    if (str_contains($message, strtolower($city))) {
                        $criteria['location'] = $city;
                        break;
                    }
                }
            }
        }

        return $criteria;
    }

    private function performSearch($criteria)
    {
        $public = Listing::query()->where('status', 'approved');
        $off = OffMarketListing::query()->where('status', 'approved');

        $apply = function (Builder $q) use ($criteria) {
            if ($criteria['purpose'])
                $q->where('purpose', $criteria['purpose']);
            if ($criteria['property_type_id'])
                $q->where('property_type_id', $criteria['property_type_id']);
            if ($criteria['bedrooms'])
                $q->where('bedrooms', $criteria['bedrooms']);

            if ($criteria['location']) {
                $loc = $criteria['location'];

                // Region Mapping
                if (strtolower($loc) === 'scotland') {
                    $q->where(function ($sq) {
                        $sq->where('address', 'like', '%Scotland%')
                            ->orWhere('address', 'like', '%Edinburgh%')
                            ->orWhere('address', 'like', '%Glasgow%')
                            ->orWhere('address', 'like', '%Aberdeen%');
                    });
                } else {
                    $q->where('address', 'like', '%' . $loc . '%');
                }
            }
        };

        $apply($public);
        $apply($off);

        $mapper = function ($item, $type) {
            $item->type = $type;
            $item->image_url = $item->thumbnail ? asset('storage/' . $item->thumbnail) : 'https://via.placeholder.com/300x200?text=No+Image';
            $item->url = $type === 'Public' ? route('listing.show', $item->slug ?? $item->id) : route('off-market-listing.show', $item->slug ?? $item->id);
            return $item;
        };

        return $public->take(6)->get()->map(fn($i) => $mapper($i, 'Public'))
            ->merge($off->take(4)->get()->map(fn($i) => $mapper($i, 'Off-Market')));
    }

    private function constructSearchReply($criteria, $count)
    {
        if ($count === 0)
            return "No matches found.";
        return "Found {$count} properties.";
    }
}
