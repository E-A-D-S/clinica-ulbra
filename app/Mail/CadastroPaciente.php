<?php

namespace App\Mail;

use App\Models\Patient;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CadastroPaciente extends Mailable
{
    use Queueable, SerializesModels;

    public Patient $patient;
    public string $assunto;
    public string $viewName;

    public function __construct(Patient $patient, string $assunto, string $viewName)
    {
        $this->patient = $patient;
        $this->assunto = $assunto;
        $this->viewName = $viewName;
    }

    public function build()
    {
        return $this->subject($this->assunto)
            ->view($this->viewName)
            ->with('p', $this->patient);
    }
}
