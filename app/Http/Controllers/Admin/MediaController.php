<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ImageResource;
use App\Models\Additional\MediaUpload;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;

class MediaController extends Controller
{
	/**
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function upload(Request $request)
	{
		$media = null;

		if ($request->hasFile('image')) {
			/** @var MediaUpload $media */
			$media = MediaUpload::create();
			$media->addMediaFromRequest('image')
                ->usingFileName(create_file_name($request->file('image')))
                ->toMediaCollection('uploads');
		}

		return response()->json($media ? new ImageResource($media->getFirstMedia('uploads')) : null);
	}

	/**
	 * @param Media $media
	 * @return JsonResponse
	 * @throws \Exception
	 */
	public function destroy(Media $media): JsonResponse
	{
		$media->delete();
		return response()->json([]);
	}
}
