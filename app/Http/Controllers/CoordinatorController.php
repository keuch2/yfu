<?php

namespace App\Http\Controllers;

use App\Models\Coordinator;
use Illuminate\Http\Request;

class CoordinatorController extends Controller
{
    public function index()
    {
        $coordinators = Coordinator::orderBy('created_at', 'desc')->get();
        return view('coordinators.index', compact('coordinators'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'region' => 'nullable|string|max:255',
        ]);

        $validated['created_by'] = auth()->id();
        Coordinator::create($validated);

        return redirect()->route('coordinators.index')->with('success', '✅ Coordinador registrado.');
    }

    public function update(Request $request, Coordinator $coordinator)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'region' => 'nullable|string|max:255',
        ]);

        $coordinator->update($validated);

        return redirect()->route('coordinators.index')->with('success', '✅ Coordinador actualizado.');
    }

    public function destroy(Coordinator $coordinator)
    {
        $coordinator->delete();
        return redirect()->route('coordinators.index')->with('success', '🗑️ Coordinador eliminado.');
    }
}
