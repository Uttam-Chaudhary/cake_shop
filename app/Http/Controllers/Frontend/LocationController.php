<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Location;

class LocationController extends Controller
{
    public function getDeliveryFee($id)
{
    $location = Location::findOrfail($id);

    if (!$location) {
        return response()->json(['error' => 'Location not found'], 404);
    }

    return response()->json([
        'delivery_fee' => $location->fee
    ]);
}
}
