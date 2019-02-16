<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
        	'id' => $this->id,
			'title' => $this->title,
			'route' => route('app.catalog.show', $this),
			'image' => $this->preview,
			'description' => str_limit($this->description, 50),
			'price' => $this->price,
			'currency' => trans('common.currency')
		];
    }
}
