<?php

namespace App\Services;

use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\PathGenerator\PathGenerator;

class CustomPathGenerator implements PathGenerator
{
	public function getPath(Media $media): string
	{
		return $this->getBasePath($media) . '/' . $media->id . '/';
	}

	public function getPathForConversions(Media $media): string
	{
		return $this->getBasePath($media) . '/' . $media->id . '/';
	}

	public function getPathForResponsiveImages(Media $media): string
	{
		return $this->getBasePath($media) . '/' . $media->id . '/r/';
	}

	protected function getBasePath(Media $media): string
	{
		return $media->collection_name;
	}
}