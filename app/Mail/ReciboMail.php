<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReciboMail extends Mailable
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

    public function __construct( $archivo, $data)
    {

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
        return $this->view('emails.Recibo')
        ->subject('¡Pago Villas de Guadalupe!')
        ->with([
            'data' => $this->data,
        ])->attachData($this->archivo,"Recibo_de_Pago.pdf");

    }
}
