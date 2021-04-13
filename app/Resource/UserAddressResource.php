<?php

namespace App\Resource;

use Hyperf\Resource\Json\ResourceCollection;

class UserAddressResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        if ( !$this instanceof ResourceCollection) {
            $this->withoutWrapping();
        }

        return [
            'id'            => $this->id,
            'province'      => $this->province,
            'city'          => $this->city,
            'district'      => $this->district,
            'address'       => $this->address,
            'full_address'  => $this->fullAddress,
            'zip'           => $this->zip,
            'contact_name'  => $this->contact_name,
            'contact_phone' => $this->contact_phone,
            'last_used_at'  => $this->last_used_at,
            'created_at'    => $this->created_at->toDateTimeString(),
            'updated_at'    => $this->updated_at->toDateTimeString(),
        ];
    }
}
