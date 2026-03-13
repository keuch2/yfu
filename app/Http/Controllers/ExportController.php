<?php

namespace App\Http\Controllers;

use App\Models\PipelinePerson;
use App\Models\Family;
use App\Models\Coordinator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function index()
    {
        return view('export.index');
    }

    public function json()
    {
        $data = [
            'inbound' => [
                'prospects' => PipelinePerson::inbound()->stage('prospect')->get(),
                'applicants' => PipelinePerson::inbound()->stage('applicant')->get(),
                'participants' => PipelinePerson::inbound()->stage('participant')->get(),
                'alumni' => PipelinePerson::inbound()->stage('alumni')->get(),
            ],
            'outbound' => [
                'prospects' => PipelinePerson::outbound()->stage('prospect')->get(),
                'applicants' => PipelinePerson::outbound()->stage('applicant')->get(),
                'participants' => PipelinePerson::outbound()->stage('participant')->get(),
                'alumni' => PipelinePerson::outbound()->stage('alumni')->get(),
            ],
            'families' => Family::all(),
            'coordinators' => Coordinator::all(),
            'export_date' => now()->toIso8601String(),
            'version' => 'YFU_Integrado_v1.0',
        ];

        $filename = 'yfu_backup_' . now()->format('Y-m-d') . '.json';

        return response()->json($data)
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    public function excel()
    {
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Participantes');

        $headers = ['ID', 'Tipo', 'Etapa', 'Nombre', 'Email', 'Teléfono', 'País', 'Programa', 'Destino', 'Fecha Inicio', 'Fecha Fin', 'Notas', 'Creado'];
        $sheet->fromArray($headers, null, 'A1');

        $row = 2;
        foreach (PipelinePerson::all() as $p) {
            $sheet->fromArray([
                $p->id,
                $p->type === 'inbound' ? 'Inbound' : 'Outbound',
                PipelinePerson::stageLabel($p->stage),
                $p->name,
                $p->email,
                $p->phone,
                $p->country,
                $p->program,
                $p->destination,
                $p->start_date?->format('Y-m-d'),
                $p->end_date?->format('Y-m-d'),
                $p->notes,
                $p->created_at->format('Y-m-d H:i'),
            ], null, 'A' . $row);
            $row++;
        }

        $familySheet = $spreadsheet->createSheet();
        $familySheet->setTitle('Familias');
        $familySheet->fromArray(['ID', 'Apellido', 'Ciudad', 'Contacto', 'Email', 'Teléfono', 'Capacidad', 'Estado', 'Creado'], null, 'A1');
        $row = 2;
        foreach (Family::all() as $f) {
            $familySheet->fromArray([
                $f->id, $f->name, $f->city, $f->contact, $f->email, $f->phone, $f->capacity, $f->status, $f->created_at->format('Y-m-d H:i'),
            ], null, 'A' . $row);
            $row++;
        }

        $coordSheet = $spreadsheet->createSheet();
        $coordSheet->setTitle('Coordinadores');
        $coordSheet->fromArray(['ID', 'Nombre', 'Email', 'Teléfono', 'Región', 'Creado'], null, 'A1');
        $row = 2;
        foreach (Coordinator::all() as $c) {
            $coordSheet->fromArray([
                $c->id, $c->name, $c->email, $c->phone, $c->region, $c->created_at->format('Y-m-d H:i'),
            ], null, 'A' . $row);
            $row++;
        }

        $filename = 'yfu_export_' . now()->format('Y-m-d') . '.xlsx';
        $temp = tempnam(sys_get_temp_dir(), 'yfu');
        $writer = new Xlsx($spreadsheet);
        $writer->save($temp);

        return response()->download($temp, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }
}
