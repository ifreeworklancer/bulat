<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\MediaLibrary\Models\Media;

class MediaController extends Controller
{
	/**
	 * @param Media $media
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Exception
	 */
	public function destroy(Media $media)
	{
		$media->delete();
		return response()->json([
			'status' => 'success',
		]);
	}
}
