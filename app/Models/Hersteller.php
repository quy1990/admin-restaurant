<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hersteller extends Model
{

    public function format(){
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'adress' => $this->adress,
            'products' => $this->Products->pluck('name', 'id'),
        ];
    }

    public function Products(){
        return $this->hasMany("App\Models\Product");
    }
}
