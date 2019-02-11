<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Subscribe extends Mailable
{
	use SerializesModels;
	public $email;

	/**
	 * Create a new message instance.
	 *
	 * @param $email
	 */
	public function __construct($email)
	{
		$this->email = $email;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		return $this
			->to(config('app.admin_email'))
			->subject('Подписка на рассылку')
			->view('mail.subscribe');
	}
}
