<?php

namespace App\Http\Controllers;

use App\Models\Family;
use Illuminate\Http\Request;

class FamilyController extends Controller
{
    private const CITIES = ['Asunción','Ciudad del Este','Encarnación','San Lorenzo','Luque','Capiatá','Lambaré','Fernando de la Mora'];

    public function index()
    {
        $families = Family::orderBy('created_at', 'desc')->get();
        return view('families.index', [
            'families' => $families,
            'cities' => self::CITIES,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string',
            'contact' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'capacity' => 'required|integer|min:1|max:5',
            'status' => 'required|in:Disponible,Ocupada',
        ]);

        $validated['created_by'] = auth()->id();
        Family::create($validated);

        return redirect()->route('families.index')->with('success', '✅ Familia registrada.');
    }

    public function update(Request $request, Family $family)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string',
            'contact' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'capacity' => 'required|integer|min:1|max:5',
            'status' => 'required|in:Disponible,Ocupada',
        ]);

        $family->update($validated);

        return redirect()->route('families.index')->with('success', '✅ Familia actualizada.');
    }

    public function destroy(Family $family)
    {
        $family->delete();
        return redirect()->route('families.index')->with('success', '🗑️ Familia eliminada.');
    }
}
