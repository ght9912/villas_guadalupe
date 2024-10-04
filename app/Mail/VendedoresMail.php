<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VendedoresMail extends Mailable
{
    use Queueable, SerializesModels;

    public $nombre;
    public $contrasena;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nombre, $contrasena)
    {
        $this->nombre = $nombre;
        $this->contrasena = $contrasena;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.vendedor')
        ->subject('¡Bienvenido a Villas de Guadalupe!')
        ->with([
            'nombre' => $this->nombre,
            'contrasena' => $this->contrasena,
        ]);

    }
}
