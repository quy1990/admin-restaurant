<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ["name", "price", "product_nummer", "hersteller_id"];

    protected $hidden = array('created_at', 'updated_at');

    public function format(){
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'product_nummer'    => $this->product_nummer,
            'hersteller'        => $this->Hersteller->name ?? "",
            'price'             => (string)$this->price ?? "",
        ];
    }

    public function Hersteller(){
        return $this->belongsTo("App\Models\Hersteller", "herstelle_id");
    }

    public function Bestellung(){
        return $this->belongsToMany("App\Models\Product", "bestellungs_products", "bestellung_id", "product_id");
    }
}
