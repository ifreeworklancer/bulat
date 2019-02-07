<?php

namespace App\Mail;

use App\Models\Catalog\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AskQuestion extends Mailable
{
	use SerializesModels;
	/**
	 * @var Request
	 */
	public $data;
	/**
	 * @var Product
	 */
	public $product;

	/**
	 * Create a new message instance.
	 *
	 * @param array $data
	 * @param Product $product
	 */
	public function __construct($data, Product $product)
	{
		$this->data = (object)$data;
		$this->product = $product;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		return $this
			->to(env('ADMIN_EMAIL'))
			->subject('Вопрос по товару')
			->view('mail.question');
	}
}
