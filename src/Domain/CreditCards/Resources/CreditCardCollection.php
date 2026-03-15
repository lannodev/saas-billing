<?php

namespace VueFileManager\Subscription\Domain\CreditCards\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CreditCardCollection extends ResourceCollection
{
    public $collects = CreditCardResource::class;

    /**
     * Transform the resource collection into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
        ];
    }
}
