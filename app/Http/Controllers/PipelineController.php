<?php

namespace App\Http\Controllers;

use App\Models\PipelinePerson;
use App\Mail\PipelineConvertedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PipelineController extends Controller
{
    private const COUNTRIES = ['Alemania','Argentina','Australia','Brasil','Canadá','Chile','Colombia','España','Estados Unidos','Finlandia','Francia','Italia','Japón','México','Nueva Zelanda','Países Bajos','Paraguay','Perú','Polonia','Reino Unido','Uruguay'];
    private const DESTINATIONS = ['Alemania','Argentina','Australia','Brasil','Canadá','Chile','Estados Unidos','Finlandia','Francia','Italia','Japón','Nueva Zelanda','Países Bajos','Polonia','Uruguay'];
    private const PROGRAMS = [
        ['code' => 'TRIM', 'name' => 'Trimestre (3 meses)', 'price' => 3725],
        ['code' => 'SEM', 'name' => 'Semestre (5-6 meses)', 'price' => 4550],
        ['code' => 'YEAR', 'name' => 'Año Académico (10 meses)', 'price' => 5390],
    ];

    public function index(string $type, string $stage)
    {
        $persons = PipelinePerson::where('type', $type)
            ->where('stage', $stage)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pipeline.index', [
            'persons' => $persons,
            'type' => $type,
            'stage' => $stage,
            'stageLabel' => PipelinePerson::stageLabel($stage),
            'typeLabel' => $type === 'inbound' ? 'Inbound' : 'Outbound',
            'countries' => self::COUNTRIES,
            'destinations' => self::DESTINATIONS,
            'programs' => self::PROGRAMS,
        ]);
    }

    public function store(Request $request, string $type, string $stage)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'country' => 'required|string',
            'notes' => 'nullable|string',
        ];

        if ($stage !== 'prospect') {
            if ($type === 'inbound') {
                $rules['program'] = 'required|string';
            } else {
                $rules['destination'] = 'required|string';
            }
        }

        if (in_array($stage, ['participant', 'alumni'])) {
            $rules['start_date'] = 'nullable|date';
            $rules['end_date'] = 'nullable|date|after_or_equal:start_date';
        }

        $validated = $request->validate($rules);
        $validated['type'] = $type;
        $validated['stage'] = $stage;
        $validated['created_by'] = auth()->id();

        PipelinePerson::create($validated);

        return redirect()->route('pipeline.index', [$type, $stage])
            ->with('success', '✅ Registro creado exitosamente.');
    }

    public function update(Request $request, string $type, string $stage, PipelinePerson $person)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'country' => 'required|string',
            'notes' => 'nullable|string',
        ];

        if ($stage !== 'prospect') {
            if ($type === 'inbound') {
                $rules['program'] = 'required|string';
            } else {
                $rules['destination'] = 'required|string';
            }
        }

        if (in_array($stage, ['participant', 'alumni'])) {
            $rules['start_date'] = 'nullable|date';
            $rules['end_date'] = 'nullable|date|after_or_equal:start_date';
        }

        $validated = $request->validate($rules);
        $person->update($validated);

        return redirect()->route('pipeline.index', [$type, $stage])
            ->with('success', '✅ Registro actualizado.');
    }

    public function destroy(string $type, string $stage, PipelinePerson $person)
    {
        $person->delete();

        return redirect()->route('pipeline.index', [$type, $stage])
            ->with('success', '🗑️ Registro eliminado.');
    }

    public function convert(string $type, string $stage, PipelinePerson $person)
    {
        $nextStage = PipelinePerson::nextStage($stage);
        if (!$nextStage) {
            return back()->with('error', '❌ No se puede convertir desde esta etapa.');
        }

        $person->update([
            'stage' => $nextStage,
            'converted_from' => $stage,
            'converted_date' => now(),
        ]);

        try {
            Mail::to(config('mail.admin_email', 'admin@yfu.org.py'))
                ->send(new PipelineConvertedMail($person, $stage, $nextStage));
        } catch (\Throwable $e) {
            // Log but don't block conversion
            \Log::warning('Email notification failed: ' . $e->getMessage());
        }

        return redirect()->route('pipeline.index', [$type, $nextStage])
            ->with('success', '✅ Convertido a ' . PipelinePerson::stageLabel($nextStage) . '.');
    }
}
