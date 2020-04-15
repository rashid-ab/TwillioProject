<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\SubServiceResource as  SubServices;
class ServiceResource extends JsonResource
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
            'name'=>$this->name,
            'image'=>$this->image,
            'price'=>$this->price,
            'text_info'=>$this->text_info,
            'services'=>SubServices::collection($this->services),
        ];
    }
}
