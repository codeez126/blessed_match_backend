<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\City;
use App\Models\Country;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminLocationsController extends Controller
{
    // List all countries
    public function index()
    {
        $countries = Country::all();
        return view('admin.countries.list', compact('countries'));
    }

    // Show create form
    public function create()
    {
        return view('admin.countries.add');
    }

    // Store new country
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:countries'
        ]);

        Country::create($validated);

        return redirect()->route('admin.countries.index')
            ->with('success', 'Country created successfully');
    }

    // Show edit form
    public function edit(Country $country)
    {
        return view('admin.countries.edit', compact('country'));
    }

    // Update country
    public function update(Request $request, Country $country)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:countries,name,'.$country->id
        ]);

        $country->update($validated);

        return redirect()->route('admin.countries.index')
            ->with('success', 'Country updated successfully');
    }

    // Delete country
    public function destroy(Country $country)
    {
        $country->delete();
        return redirect()->route('admin.countries.index')
            ->with('success', 'Country deleted successfully');
    }











    // Province Methods
    public function provincesIndex()
    {
        $provinces = Province::with('country')->get();
        return view('admin.provinces.list', compact('provinces'));
    }

    public function provincesCreate()
    {
        $countries = Country::all();
        return view('admin.provinces.add', compact('countries'));
    }

    public function provincesStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'country_id' => 'required|exists:countries,id'
        ]);

        Province::create($validated);

        return redirect()->route('admin.provinces.index')
            ->with('success', 'Province created successfully');
    }

    public function provincesEdit(Province $province)
    {
        $countries = Country::all();
        return view('admin.provinces.edit', compact('province', 'countries'));
    }

    public function provincesUpdate(Request $request, Province $province)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'country_id' => 'required|exists:countries,id'
        ]);

        $province->update($validated);

        return redirect()->route('admin.provinces.index')
            ->with('success', 'Province updated successfully');
    }

    public function provincesDestroy(Province $province)
    {
        $province->delete();
        return redirect()->route('admin.provinces.index')
            ->with('success', 'Province deleted successfully');
    }






    public function cityindex()
    {
        $cities = City::with(['province.country'])->get();
        return view('admin.cities.list', compact('cities'));
    }

    public function citycreate()
    {
        $countries = Country::all();
        $provinces = Province::with('country')->get();

        return view('admin.cities.add', compact('countries', 'provinces'));        return view('admin.cities.add', compact('countries'));
    }

    public function citystore(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('cities')->where(function ($query) use ($request) {
                    return $query->where('province_id', $request->province_id);
                })
            ],
            'country_id' => 'required|exists:countries,id',
            'province_id' => 'required|exists:provinces,id'
        ]);

        City::create([
            'name' => $validated['name'],
            'province_id' => $validated['province_id']
        ]);

        return redirect()->route('admin.cities.index')
            ->with('success', 'City created successfully');
    }

    public function cityedit(City $city)
    {
        $countries = Country::all();
        $provinces = Province::where('country_id', $city->province->country_id)->get();
        return view('admin.cities.edit', compact('city', 'countries', 'provinces'));
    }

    public function cityupdate(Request $request, City $city)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('cities')->where(function ($query) use ($request, $city) {
                    return $query->where('province_id', $request->province_id)
                        ->where('id', '!=', $city->id);
                })
            ],
            'country_id' => 'required|exists:countries,id',
            'province_id' => 'required|exists:provinces,id'
        ]);

        $city->update([
            'name' => $validated['name'],
            'province_id' => $validated['province_id']
        ]);

        return redirect()->route('admin.cities.index')
            ->with('success', 'City updated successfully');
    }

    public function citydestroy(City $city)
    {
        $city->delete();
        return redirect()->route('admin.cities.index')
            ->with('success', 'City deleted successfully');
    }

    // AJAX Methods
    public function getProvinces($country_id)
    {
        try {
            // Adjust the model name and column names according to your database structure
            $provinces = \App\Models\Province::where('country_id', $country_id)
                ->select('id', 'name')
                ->get();

            return response()->json($provinces);
        } catch (\Exception $e) {
            \Log::error('Error fetching provinces: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch provinces'], 500);
        }
    }

    public function checkName(Request $request)
    {
        $exists = City::where('name', $request->name)
            ->where('province_id', $request->province_id)
            ->exists();

        return response()->json(['exists' => $exists]);
    }









    public function areaindex()
    {
        $areas = Area::with(['city.province.country'])->get();
        return view('admin.areas.list', compact('areas'));
    }

    public function areacreate()
    {
        $countries = Country::all();
        $provinces = Province::all();
        $cities = City::all();
        return view('admin.areas.add', compact('countries', 'provinces', 'cities'));
    }

    public function areastore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'country_id' => 'required|exists:countries,id',
            'province_id' => 'required|exists:provinces,id',
            'city_id' => 'required|exists:cities,id'
        ]);

        Area::create($request->only(['name', 'city_id']));

        return redirect()->route('admin.areas.index')
            ->with('success', 'Area created successfully');
    }

    public function areaedit(Area $area)
    {
        $countries = Country::all();
        $provinces = Province::all();
        $cities = City::all();
        return view('admin.areas.edit', compact('area', 'countries', 'provinces', 'cities'));
    }

    public function areaupdate(Request $request, Area $area)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'country_id' => 'required|exists:countries,id',
            'province_id' => 'required|exists:provinces,id',
            'city_id' => 'required|exists:cities,id'
        ]);

        $area->update($request->only(['name', 'city_id']));

        return redirect()->route('admin.areas.index')
            ->with('success', 'Area updated successfully');
    }

    public function areadestroy(Area $area)
    {
        $area->delete();
        return redirect()->route('admin.areas.index')
            ->with('success', 'Area deleted successfully');
    }
}
