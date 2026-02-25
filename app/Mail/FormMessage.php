<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FormMessage extends Mailable
{
    use Queueable, SerializesModels;

    public $form_email;

    public $form_subject;

    public $form_message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $email, string $subject, string $message)
    {
        $this->form_email = $email;
        $this->form_subject = $subject;
        $this->form_message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.form-message')->subject('New Form Message from Turnip Queue')->replyTo($this->form_email);
    }
}
