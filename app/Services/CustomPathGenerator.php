<?php

namespace App\Services;

use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\PathGenerator\PathGenerator;

class CustomPathGenerator implements PathGenerator
{
	/**
	 * @param Media $media
	 * @return string
	 */
	public function getPath(Media $media): string
	{
		return $this->getBasePath($media) . '/' . $this->hash($media) . '/';
	}

	/**
	 * @param Media $media
	 * @return string
	 */
	public function getPathForConversions(Media $media): string
	{
		return $this->getBasePath($media) . '/' . $this->hash($media) . '/';
	}

	/**
	 * @param Media $media
	 * @return string
	 */
	public function getPathForResponsiveImages(Media $media): string
	{
		return $this->getBasePath($media) . '/' . $this->hash($media) . '/r/';
	}

	/**
	 * @param Media $media
	 * @return string
	 */
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