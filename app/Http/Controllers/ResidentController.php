<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class ResidentController extends Controller
{
    //
    public function index()
    {
        // Logic to retrieve and display residents
        $residents = Resident::all();
        return view('pages.resident.index', [
            'residents' => $residents
        ]);
    }

    public function store(Request $request)
    {
        // Logic to store a new resident
        $data = $request->validate([
            'nik' => ['required', 'max:16', 'min:16'],
            'name' => ['required', 'max:100'],
            'gender' => ['required', Rule::in(['male', 'female'])],
            'birth_date' => ['required', 'string'],
            'birth_place' => ['required', 'max:100'],
            'address' => ['required', 'max:255'],
            'religion' => ['nullable', 'max:50'],
            'marital_status' => ['required', Rule::in(['single', 'married', 'divorced', 'widowed'])],
            'occupation' => ['nullable', 'max:100'],
            'phone' => ['nullable', 'max:15'],
            'status' => ['required', Rule::in(['active', 'moved', ' deceased'])],
        ]);

        Resident::create($data);
        return redirect('/resident')->with('success', 'Resident created successfully.');
    }

    public function create()
    {
        // Logic to show the form for creating a new resident
        return view('pages.resident.create');
    }

    public function updadate(Request $request, $id)
    {
        // Logic to update an existing resident
        $resident = Resident::findOrFail($id);
        $data = $request->validate([
            'nik' => ['required', 'max:16', 'min:16'],
            'name' => ['required', 'max:100'],
            'gender' => ['required', Rule::in(['male', 'female'])],
            'birth_date' => ['required', 'string'],
            'birth_place' => ['required', 'max:100'],
            'address' => ['required', 'max:255'],
            'religion' => ['nullable', 'max:50'],
            'marital_status' => ['required', Rule::in(['single', 'married', 'divorced', 'widowed'])],
            'occupation' => ['nullable', '  max:100'],
            'phone' => ['nullable', 'max:15'],
            'status' => ['required', Rule::in(['active', 'moved', 'deceased'])],
        ]);

        Resident::findOrFail($id)->update($request->validated());
        return redirect('/resident')->with('success', 'Resident updated successfully.');
    }

    public function edit($id)
    {
        // Logic to show the form for editing an existing resident
        $resident = Resident::findOrFail($id);
        return view('pages.resident.edit', [
            'resident' => $resident
        ]);
    }

    public function destroy($id)
    {
        // Logic to delete a resident
        $resident = Resident::findOrFail($id);
        $resident->delete();
        return redirect('/resident')->with('success', 'Resident deleted successfully.');
    }

}
