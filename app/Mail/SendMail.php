<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    private $cake;
    private $mail;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($cake, $mail)
    {
        $this->mail = $mail;
        $this->cake = $cake;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject("Reserva do Bolo {$this->cake->nome} esta disponível!");
        $this->to($this->mail->email);
        return $this->view('mail.sendMail', [
            "mail" => $this->mail,
            "cake" => $this->cake
        ]);
    }
}
