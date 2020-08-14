<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BestellungResource;
use Illuminate\Http\Request;
use App\Models\Bestellung;
use App\Repositories\BestellungRepository;
use App\Repositories\ProductRepository;
use Lukasoppermann\Httpstatus\Httpstatuscodes as Httpstatus;


class BestellungController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(BestellungRepository::getAll(), Httpstatus::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(BestellungRequest $request)
    {
        return response()->json(BestellungRepository::store($request), Httpstatus::HTTP_OK);
    }

    /**
     * Store more newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function storeJson(Request $request, $id)
    {
        $data = json_decode($request->getContent(), true);
        $bestellung_product = array();
        $bestellung = BestellungRepository::update($data);
        foreach ($data["products"] as $item) {
            $product = ProductRepository::store($item);
            $bestellung_product[$product->id]
                = array('menge' => $item['menge']);
        }

        $bestellung->products()->sync($bestellung_product);
        return response()->json(BestellungRepository::show($id), Httpstatus::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(BestellungRepository::show($id), Httpstatus::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(BestellungRequest $request, $id)
    {
        return response()->json(BestellungRepository::store($request), Httpstatus::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        BestellungRepository::delete($id);
        return response()->json([], Httpstatus::HTTP_NO_CONTENT);
    }
}
