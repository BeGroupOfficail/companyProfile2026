<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CountryResource;
use App\Models\Dashboard\Country\Country;
use Illuminate\Http\Request;
use function App\Helper\apiResponse;
class CountryController extends Controller
{
    public function index(Request $request)
    {
        $countries = Country::query()
            ->when($request->search, function ($query) use ($request) {
                $query->where('name->en', 'like', "%{$request->search}%")
                    ->orWhere('name->ar', 'like', "%{$request->search}%");
            })
            ->orderBy('name->en', 'asc')
            ->get();

        return apiResponse(200, CountryResource::collection($countries), __('home.Countries fetched successfully'));
    }
}
