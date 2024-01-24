<?php

namespace Module\WebsiteCMS\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
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
            'id'                   => $this->id,
            'category_id'          => $this->category_id,
            'title'                => $this->title,
            'slug'                 => $this->slug,
            'thumbnail_image'      => $this->thumbnail_image != null && file_exists($this->thumbnail_image) ? $this->thumbnail_image : null,
            'cover_image'          => $this->cover_image != null && file_exists($this->cover_image) ? $this->cover_image : null,
            'short_description'    => $this->short_description,
            'description'          => $this->description,
            'createdBlog'          => $this->created_at->format('Y-m-d'),
            'updatedBlog'          => $this->updated_at->format('Y-m-d '),
            'category'             => [
                'categoryName'     => optional($this->blogCategory)->name,
                'categorySlug'     => optional($this->blogCategory)->slug,
            ],
            'created'            => [

                'username'      =>         optional($this->user)->username,
            ]
        ];
    }
}
