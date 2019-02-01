<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class FileStoring implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
	private $model;
	private $file;
	private $loop;
	private $user;

	/**
	 * Create a new job instance.
	 *
	 * @param $model
	 * @param $base64
	 * @param $loop
	 */
	public function __construct($model, $base64, $loop, $user)
	{
		$this->model = $model;
		$this->file = $base64;
		$this->loop = $loop;
		$this->user = $user;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
		$this->model->addMediaFromBase64($this->file)
					->setFileName("{$this->user}__{$this->model->id}-{$this->loop}__.jpg")
					->toMediaCollection('answers');
	}
}
