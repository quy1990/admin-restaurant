<?php

namespace App\Repositories;

use App\Models\Food;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class FoodRepository.
 */
class FoodRepository
{

    public static function getAll(){
        return Food::all();
    }

    public static function get($id){
        return Food::find($id);
    }

    public static function show($id){
        return self::get($id)->format();
    }

    public static function delete($id){
        $Food = Food::find($id);
        if(is_null($Food)){
            throw new Exception("Not found this Food with Id =". $id);
        }
        $Food->delete;
    }

    public static function update($request){
        return self::get($request->get("id"))->update([
            "created_at" =>$request->get("created_at"),
            "updated_at" =>$request->get("updated_at"),
        ]);
    }

    
    public static function store($request){
        return Food::create([
            "created_at" =>$request->get("created_at"),
            "updated_at" =>$request->get("updated_at"),
        ]);
    }
}
