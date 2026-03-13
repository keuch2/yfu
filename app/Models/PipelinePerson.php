<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PipelinePerson extends Model
{
    protected $table = 'pipeline_persons';

    protected $fillable = [
        'type',
        'stage',
        'name',
        'email',
        'phone',
        'country',
        'program',
        'destination',
        'start_date',
        'end_date',
        'notes',
        'converted_from',
        'converted_date',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'converted_date' => 'datetime',
        ];
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeInbound($query)
    {
        return $query->where('type', 'inbound');
    }

    public function scopeOutbound($query)
    {
        return $query->where('type', 'outbound');
    }

    public function scopeStage($query, string $stage)
    {
        return $query->where('stage', $stage);
    }

    public static function stageLabel(string $stage): string
    {
        return match ($stage) {
            'prospect' => 'Interesado',
            'applicant' => 'Postulante',
            'participant' => 'Participante',
            'alumni' => 'Alumni',
            default => $stage,
        };
    }

    public static function nextStage(string $stage): ?string
    {
        return match ($stage) {
            'prospect' => 'applicant',
            'applicant' => 'participant',
            'participant' => 'alumni',
            default => null,
        };
    }
}
