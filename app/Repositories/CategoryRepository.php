<?php

namespace App\Repositories;

use App\Models\Category;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class CategoryRepository.
 */
class CategoryRepository
{

    public static function getAll(){
        return Category::all();
    }

    public static function get($id){
        return Category::find($id);
    }

    public static function show($id){
        return self::get($id)->format();
    }

    public static function delete($id){
        $Category = Category::find($id);
        if(is_null($Category)){
            throw new Exception("Not found this Category with Id =". $id);
        }
        $Category->delete;
    }

    public static function update($request){
        return self::get($request->get("id"))->update([
            "created_at" =>$request->get("created_at"),
            "updated_at" =>$request->get("updated_at"),
        ]);
    }

    
    public static function store($request){
        return Category::create([
            "created_at" =>$request->get("created_at"),
            "updated_at" =>$request->get("updated_at"),
        ]);
    }
}
