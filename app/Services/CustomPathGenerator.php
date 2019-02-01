<?php

namespace App\Services;

use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\PathGenerator\PathGenerator;

class CustomPathGenerator implements PathGenerator
{
	public function getPath(Media $media): string
	{
		return $this->getBasePath($media) . '/' . $this->hash($media) . '/';
	}

	public function getPathForConversions(Media $media): string
	{
		return $this->getBasePath($media) . '/' . $this->hash($media) . '/';
	}

	public function getPathForResponsiveImages(Media $media): string
	{
		return $this->getBasePath($media) . '/' . $this->hash($media) . '/r/';
	}

	protected function getBasePath(Media $media): string
	{
		return $media->collection_name;
	}

	/**
	 * @param Media $media
	 * @return bool|string
	 */
	private function hash(Media $media)
	{
		return substr(md5($media->id), 0, 6);
	}
}