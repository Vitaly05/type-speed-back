<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResetPasswordRequestMail extends Mailable
{
	use Queueable, SerializesModels;

	protected string $code;

	/**
	 * Create a new message instance.
	 */
	public function __construct( $code )
	{
		$this->code = $code;
	}

	/**
	 * Get the message envelope.
	 */
	public function envelope() : Envelope
	{
		return new Envelope(
			subject: __( 'Запрос на сброс пароля' ),
		);
	}

	/**
	 * Get the message content definition.
	 */
	public function content() : Content
	{
		return new Content(
			view: 'emails.templates.reset-password-request',
			with: [
				'code' => $this->code,
			],
		);
	}

	/**
	 * Get the attachments for the message.
	 *
	 * @return array<int, \Illuminate\Mail\Mailables\Attachment>
	 */
	public function attachments() : array
	{
		return [];
	}
}
