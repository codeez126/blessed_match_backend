<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Religion;
use Illuminate\Http\Request;

class AdminReligionController extends Controller
{
    public function index()
    {
        $religions = Religion::withCount(['sects', 'casts'])->get();
        return view('admin.religions.list', compact('religions'));
    }

    public function create()
    {
        return view('admin.religions.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:religions'
        ]);

        Religion::create($request->only('name'));

        return redirect()->route('admin.religions.index')
            ->with('success', 'Religion created successfully');
    }

    public function edit(Religion $religion)
    {
        return view('admin.religions.edit', compact('religion'));
    }

    public function update(Request $request, Religion $religion)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:religions,name,'.$religion->id
        ]);

        $religion->update($request->only('name'));

        return redirect()->route('admin.religions.index')
            ->with('success', 'Religion updated successfully');
    }

    public function destroy(Religion $religion)
    {
        $religion->delete();
        return redirect()->route('admin.religions.index')
            ->with('success', 'Religion deleted successfully');
    }
}
