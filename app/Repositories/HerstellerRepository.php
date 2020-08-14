<?php

namespace App\Repositories;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class HerstellerResource.
 */
class HerstellerRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        //return YourModel::class;
    }

    public static function getAll(){
        return Hersteller::all()
                            ->map(
                                function($object){
                                    return $object->format();
                                }

        );
    }

    public static function show($id){
        return Hersteller::find($id)->first()->format();
    }
}
