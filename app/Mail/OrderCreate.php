<?php

namespace App\Mail;

use App\Models\Catalog\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderCreate extends Mailable
{
	use SerializesModels;
	/**
	 * @var Order
	 */
	public $order;

	/**
	 * Create a new message instance.
	 *
	 * @param Order $order
	 */
	public function __construct(Order $order)
	{
		$this->order = $order;
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
			->subject('Заказ с сайта')
			->view('mail.order');
	}
}
