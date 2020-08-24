<?php


namespace App\Repositories\Traits;


use App\Models\User;
use Illuminate\Http\Request;

trait GeneralFunctionTrait
{
    public function __construct(Request $request)
    {
        $this->user = User::find($request->user()->id);
    }

    /**
     * @param $request
     * @param $id
     * @return array
     */
    public function update($request, int $id): array
    {
        return self::get($id)->update($request->all())->format();
    }
}
