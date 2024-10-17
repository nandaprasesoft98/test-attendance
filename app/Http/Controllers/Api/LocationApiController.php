<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Location;
use Illuminate\Support\Facades\Auth;
use Validator;

class LocationApiController extends BaseApiController
{
    public function getLocationList(Request $request)
    {
        $locations = Location::all();
        if (count($locations) == 0) {
            return $this->sendError("Location is empty.");
        }
        return $this->sendResponse($locations, "Success get location list");
    }

    public function createLocation(Request $request)
    {
        $requestParameter = $request->all();
        $validator = Validator::make($requestParameter, [
            'name' => 'required',
            'description' => 'required',
            'longitude' => 'longitude',
            'latitude' => 'latitude',
        ]);

        if ($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        Location::create([
            'name' => $requestParameter["name"],
            'description' => $requestParameter["description"],
            'longitude' => $requestParameter["longitude"],
            'latitude' => $requestParameter["latitude"]
        ]);
    }

    public function updateLocation(Request $request)
    {
        $location = Location::find(1);
        $location->name = 'Paris to London';
        $location->save();
    }
}
