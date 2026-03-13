<?php

namespace App\Http\Controllers;

use App\Models\PipelinePerson;
use App\Models\Family;
use App\Models\Coordinator;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'ib_prospect' => PipelinePerson::inbound()->stage('prospect')->count(),
            'ib_applicant' => PipelinePerson::inbound()->stage('applicant')->count(),
            'ib_participant' => PipelinePerson::inbound()->stage('participant')->count(),
            'ib_alumni' => PipelinePerson::inbound()->stage('alumni')->count(),
            'ob_prospect' => PipelinePerson::outbound()->stage('prospect')->count(),
            'ob_applicant' => PipelinePerson::outbound()->stage('applicant')->count(),
            'ob_participant' => PipelinePerson::outbound()->stage('participant')->count(),
            'ob_alumni' => PipelinePerson::outbound()->stage('alumni')->count(),
            'families' => Family::count(),
            'coordinators' => Coordinator::count(),
        ];

        return view('dashboard', compact('stats'));
    }
}
