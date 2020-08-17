<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static truncate()
 */
class People extends Model
{

    protected $table = "peoples";

    protected $fillable = ['invitation_id', 'user_id', 'restaurant_id', 'email', 'phone'];
    /**
     * @return array
     */
    public function format(): array
    {
        return [
            'id'            => $this->id,
            'invitation_id' => $this->invitation_id,
            'user_id'       => $this->user_id,
            'restaurant_id' => $this->restaurant_id,
            'email'         => $this->email,
            'phone'         => $this->phone,
        ];
    }

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
