<?php

namespace App\Resource;

use Hyperf\Resource\Json\JsonResource;
use Hyperf\Resource\Json\ResourceCollection;

class BaseResource extends JsonResource
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

        return parent::toArray();
    }
}
