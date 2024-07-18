<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
// use Illuminate\Mail\Attachment;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;


// class ContactMailable extends Mailable
class ContactMailable extends Mailable implements ShouldQueue // para trabajar con correos en cola
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('promociones@andershopy.com', 'Promociones Finales'), // correo y nombre del remitente 
            replyTo: [
                new Address('soportepromociones@andershopy.com', 'Soporte promociones') // correo y nombre a donde se enviarán las respuestas
            ],
            subject: 'Mensaje de Contacto',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mails.contact',
            with: [
                'data' => $this->data
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        // return [
        //     Attachment::fromStorage($this->data['file']), // desde procesos en cola queue
        //     // Attachment::fromPath($this->data['file']->getRealPath()) // desde procesos sincronicos
        //     // ->as($this->data['file']->getClientOriginalName())
        //     // ->withMime($this->data['file']->getMimeType()), // tipado
        // ];

        return isset($this->data['file']) ? [ Attachment::fromStorage($this->data['file']) ] : [];
    }
}
