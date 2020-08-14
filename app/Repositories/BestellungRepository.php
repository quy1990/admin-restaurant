<?php

namespace App\Repositories;

use App\Models\Bestellung;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class BestellungRepository.
 */
class BestellungRepository
{

    public static function getAll(){
        return Bestellung::paginate(10);
    }

    public static function get($id){
        return Bestellung::find($id);
    }

    public static function show($id){
        return self::get($id)->format();
    }

    public static function delete($id){
        $bestellung = Bestellung::find($id);
        if(is_null($bestellung)){
            throw new Exception("Not found this Bestellung with Id =". $id);
        }
        $bestellung->delete;
    }

    public static function update($request){
        return self::get($request->get("id"))->update([
            "created_at" =>$request->get("created_at"),
            "updated_at" =>$request->get("updated_at"),
        ]);
    }

    
    public static function store($request){
        return Bestellung::create([
            "created_at" =>$request->get("created_at"),
            "updated_at" =>$request->get("updated_at"),
        ]);
    }
}
