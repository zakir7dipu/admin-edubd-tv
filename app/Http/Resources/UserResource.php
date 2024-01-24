<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id'            => $this->id,
            'role'          => optional($this->role)->name,
            'firstName'     => $this->first_name,
            'lastName'      => $this->last_name,
            'username'      => $this->username,
            'email'         => $this->email,
            'phone'         => $this->phone,
            'gender'        => $this->gender,
            'experience'    => $this->experience,
            'bio'           => $this->bio,
            'avatar'        => $this->image != null && file_exists($this->image) ? $this->image : null,
            'country'       => optional($this->country)->name,
            'state'         => optional($this->state)->name,
            'city'          => optional($this->city)->name,
            'address_1'     => $this->address_1,
            'address_2'     => $this->address_2,
            'postcode'      => $this->postcode,
        ];
    }
}
