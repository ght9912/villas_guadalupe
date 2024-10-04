<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OfertasMail extends Mailable
{
    use Queueable, SerializesModels;

    public $archivo;
    public $user;
    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct($user, $archivo, $data)
    {
        $this->user = $user;
        $this->archivo = $archivo;
        $this->data = $data;
        }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.oferta')
        ->subject('¡Oferta Villas de Guadalupe!')
        ->with([
            'vendedor' => $this->user,
            'data' => $this->data,
        ])->attachData($this->archivo,"cotizacion.pdf");

    }
}
