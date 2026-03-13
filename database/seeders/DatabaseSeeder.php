<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\PipelinePerson;
use App\Models\Family;
use App\Models\Coordinator;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $super = User::create([
            'name' => 'Admin YFU',
            'email' => 'admin@yfu.org.py',
            'password' => 'password',
            'role' => 'super_admin',
        ]);

        User::create([
            'name' => 'Coordinador YFU',
            'email' => 'coord@yfu.org.py',
            'password' => 'password',
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Agente YFU',
            'email' => 'agente@yfu.org.py',
            'password' => 'password',
            'role' => 'agent',
        ]);

        // Inbound Prospects
        PipelinePerson::create(['type' => 'inbound', 'stage' => 'prospect', 'name' => 'Hans Mueller', 'email' => 'hans@email.de', 'phone' => '+49-123-456789', 'country' => 'Alemania', 'created_by' => $super->id]);
        PipelinePerson::create(['type' => 'inbound', 'stage' => 'prospect', 'name' => 'Sophie Dubois', 'email' => 'sophie@email.fr', 'phone' => '+33-1-23456789', 'country' => 'Francia', 'created_by' => $super->id]);

        // Inbound Applicant
        PipelinePerson::create(['type' => 'inbound', 'stage' => 'applicant', 'name' => 'Emma Schmidt', 'email' => 'emma@email.de', 'phone' => '+49-987-654321', 'country' => 'Alemania', 'program' => 'Año Académico (10 meses)', 'created_by' => $super->id]);

        // Inbound Participant
        PipelinePerson::create(['type' => 'inbound', 'stage' => 'participant', 'name' => 'João Silva', 'email' => 'joao@email.br', 'phone' => '+55-11-98765-4321', 'country' => 'Brasil', 'program' => 'Semestre (5-6 meses)', 'start_date' => '2026-01-15', 'end_date' => '2026-06-30', 'created_by' => $super->id]);

        // Inbound Alumni
        PipelinePerson::create(['type' => 'inbound', 'stage' => 'alumni', 'name' => 'Yuki Tanaka', 'email' => 'yuki@email.jp', 'phone' => '+81-3-1234-5678', 'country' => 'Japón', 'program' => 'Año Académico (10 meses)', 'start_date' => '2025-02-01', 'end_date' => '2025-12-15', 'created_by' => $super->id]);

        // Outbound Prospects
        PipelinePerson::create(['type' => 'outbound', 'stage' => 'prospect', 'name' => 'María González', 'email' => 'maria@email.com', 'phone' => '+595981111111', 'country' => 'Paraguay', 'created_by' => $super->id]);
        PipelinePerson::create(['type' => 'outbound', 'stage' => 'prospect', 'name' => 'Carlos Benítez', 'email' => 'carlos@email.com', 'phone' => '+595981222222', 'country' => 'Paraguay', 'created_by' => $super->id]);

        // Outbound Applicant
        PipelinePerson::create(['type' => 'outbound', 'stage' => 'applicant', 'name' => 'Ana Martínez', 'email' => 'ana@email.com', 'phone' => '+595981333333', 'country' => 'Paraguay', 'destination' => 'Alemania', 'created_by' => $super->id]);

        // Outbound Participant
        PipelinePerson::create(['type' => 'outbound', 'stage' => 'participant', 'name' => 'Luis Fernández', 'email' => 'luis@email.com', 'phone' => '+595981444444', 'country' => 'Paraguay', 'destination' => 'Estados Unidos', 'start_date' => '2026-01-10', 'end_date' => '2026-11-30', 'created_by' => $super->id]);

        // Outbound Alumni
        PipelinePerson::create(['type' => 'outbound', 'stage' => 'alumni', 'name' => 'Sofía Rodríguez', 'email' => 'sofia@email.com', 'phone' => '+595981555555', 'country' => 'Paraguay', 'destination' => 'Francia', 'start_date' => '2024-08-15', 'end_date' => '2025-06-30', 'created_by' => $super->id]);

        // Families
        Family::create(['name' => 'González', 'city' => 'Asunción', 'contact' => 'Roberto González', 'email' => 'familia.gonzalez@email.com', 'phone' => '+595981123456', 'capacity' => 2, 'status' => 'Disponible', 'created_by' => $super->id]);
        Family::create(['name' => 'Pérez', 'city' => 'Ciudad del Este', 'contact' => 'María Pérez', 'email' => 'familia.perez@email.com', 'phone' => '+595981234567', 'capacity' => 1, 'status' => 'Disponible', 'created_by' => $super->id]);

        // Coordinators
        Coordinator::create(['name' => 'María López', 'email' => 'maria.lopez@yfu.org.py', 'phone' => '+595981555123', 'region' => 'Asunción', 'created_by' => $super->id]);
        Coordinator::create(['name' => 'Juan Ramírez', 'email' => 'juan.ramirez@yfu.org.py', 'phone' => '+595981666234', 'region' => 'Central', 'created_by' => $super->id]);
    }
}
