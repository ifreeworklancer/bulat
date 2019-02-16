<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
	/**
	 * Transform the resource collection into an array.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return array
	 */
	public function toArray($request)
	{
		return [
			'items' => ProductResource::collection($this->collection),
			'pagination' => [
				'current' => $this->currentPage(),
				'total' => $this->lastPage(),
				'next' => $this->currentPage() !== $this->lastPage() ? $this->currentPage() + 1 : null,
			],
		];
	}
}
