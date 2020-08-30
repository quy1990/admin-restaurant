<?php


namespace App\Repositories\Traits;


use App\Models\User;
use Illuminate\Http\Request;

/**
 * @property  user
 */
trait GeneralFunctionTrait
{
    public function __construct(Request $request)
    {
        $this->user = $request->user();
    }

    /**
     * @param Request $request
     * @param $id
     * @return array
     */
    public function update(Request $request, int $id): array
    {
        return tap(self::get($id))->update($request->all())->format();
    }

    /**
     * @param $object
     * @return array
     */
    public function show($object): array
    {
        return $object->format();
    }

    /**
     * @param $object
     * @return bool|null
     */
    public function delete($object)
    {
        return $object->delete();
    }
}
