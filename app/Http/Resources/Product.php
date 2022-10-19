<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'product_code' => $this->product_code,
            'product_name' => $this->product_name,
            'product_slug' => $this->product_slug,
            'image' => $this->image,
            'short_description' => $this->short_description,
            'description' => $this->description,
            'is_continued' => $this->is_continued,
            'is_featured' => $this->is_featured,
            'is_new' => $this->is_new,
            'category_id' => $this->category_id,
            'supplier_id' => $this->supplier_id,
        ];
    }
}
