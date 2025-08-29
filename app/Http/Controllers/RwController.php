<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RwUnit;

class RwController extends Controller
{
    //
        public function index()
    {
        // Logic to retrieve and display residents
        $rw_units = RwUnit::paginate(3);
        return view('pages.rw-unit.index', [
            'rw_units' => $rw_units
        ]);
    }

    public function store(Request $request)
    {
        // Logic to store a new resident
        $data = $request->validate([
            'number' => ['required', 'max:3', 'min:2'],
        ]);

        RwUnit::create($data);
        return redirect('/rw-unit')->with('success', 'RW created successfully.');
    }

    public function create()
    {
        // Logic to show the form for creating a new resident
        return view('pages.rw-unit.create');
    }

    public function update(Request $request, $id)
    {
        // Logic to update an existing resident
        $rw_units = RwUnit::findOrFail($id);
        $data = $request->validate([
            'number' => ['required', 'max:3', 'min:2'],
        ]);

        // Update rw_units
        $rw_units = RwUnit::findOrFail($id);
        $rw_units->update($data);

        return redirect('/rw-unit')->with('success', 'RW updated successfully.');
    }

    public function edit($id)
    {
        // Logic to show the form for editing an existing resident
        $rw_units = RwUnit::findOrFail($id);
        return view('pages.rw-unit.edit', [
            'rw_units' => $rw_units
        ]);
    }

    public function show($id)
    {
        // Logic to show a specific resident
        $rw_units = RwUnit::findOrFail($id);
        return view('pages.rw-unit.edit', [
            'rw_unit' => $rw_units
        ]);
    }

    public function destroy($id)
    {
        // Logic to delete a resident
        $rw_units = RwUnit::findOrFail($id);
        $rw_units->delete();
        return redirect('/rw-unit')->with('success', 'RW deleted successfully.');
    }
}
