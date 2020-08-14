<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BestellungResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $total = 0;
        for($i =0 ; $i<count($this->products); $i++){
            $total                         += $this->products[$i]['pivot']->menge * $this->products[$i]['price'];
            $this->products[$i]['menge']    = $this->products[$i]['pivot']->menge;
            $this->products[$i]             = $this->products[$i]
                                                    ->makeHidden(
                                                        'pivot', 
                                                        'created_at', 
                                                        'updated_at', 
                                                        'hersteller_id', 
                                                        'product_nummer');
        }

        return [
            'id'            => $this->id,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
            'total'         => $total,
            'products'      => $this->products,
        ];
    }
}
