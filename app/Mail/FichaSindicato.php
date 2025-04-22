<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class FichaSindicato extends Mailable
{
    use Queueable, SerializesModels;
    public $dados;
    public $arquivos;

    /**
     * Create a new message instance.
     *
     * @return void
     */


    public function __construct($dados, $arquivos)
    {
        $this->dados = $dados;
        $this->arquivos = $arquivos;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->from('secretaria@sinpol.org.br', 'Sinpol')
            ->subject('Ficha de sindicalização')
            ->view('emails.ficha')
            ->with([
                'dados' => $this->dados,
                'arquivos' => $this->arquivos,
            ]);

        foreach ($this->arquivos as $arquivo) {
            $email->attach(Storage::disk('public')->path($arquivo));
        }

        return $email;
    }
}
