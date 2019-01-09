<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UploadImage implements ShouldQueue
{
	use Dispatchable, SerializesModels;
	private $model;
	private $file;
	/**
	 * @var bool
	 */
	private $seeder;

	/**
	 * Create a new job instance.
	 *
	 * @param $model
	 * @param $file
	 * @param bool $seeder
	 */
	public function __construct($model, $file, $seeder = false)
	{
		$this->model = $model;
		$this->file = $file;
		$this->seeder = $seeder;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
		if ($this->seeder) {
			$this->model->addMediaFromUrl($this->file)->toMediaCollection('products');
		}
	}
}
