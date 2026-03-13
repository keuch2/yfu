<?php

namespace App\Mail;

use App\Models\PipelinePerson;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PipelineConvertedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public PipelinePerson $person,
        public string $fromStage,
        public string $toStage,
    ) {}

    public function envelope(): Envelope
    {
        $typeLabel = $this->person->type === 'inbound' ? 'Inbound' : 'Outbound';
        return new Envelope(
            subject: "YFU - {$this->person->name} convertido a " . PipelinePerson::stageLabel($this->toStage) . " ({$typeLabel})",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.pipeline-converted',
        );
    }
}
