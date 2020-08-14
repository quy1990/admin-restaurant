<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bestellung extends Model
{
    protected $hidden = array('created_at', 'updated_at');

    public function format(){
        $total = 0;
        for($i =0 ; $i<count($this->Products); $i++){
            $total                         += $this->Products[$i]['pivot']->menge * $this->Products[$i]['price'];
            $this->Products[$i]['menge']    = $this->Products[$i]['pivot']->menge;
            $this->Products[$i]             = $this->Products[$i]
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
            'products'      => $this->Products,
        ];
    }

    public function Products(){
        return $this
        ->belongsToMany("App\Models\Product", "bestellungs_products", "bestellung_id", "product_id")
        ->withPivot("menge");
        ;
    }
}
