<?php

namespace Module\CourseManagement\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShowInMenuCourseCategoryResource extends JsonResource
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
            'id'                => $this->id,
            'parentId'          => $this->parent_id,
            'name'              => $this->name,
            'slug'              => $this->slug,
            'shortDescription'  => $this->short_description,
            'icon'              => $this->icon != null && file_exists($this->icon) ? $this->icon : null,
            'childCategories'   => $this->whenLoaded('showInMenuChildCourseCategories'),
            'childCount'        => $this->showInMenuChildCourseCategories->count(),
        ];
    }
}
