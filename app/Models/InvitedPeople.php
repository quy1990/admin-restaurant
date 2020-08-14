<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static truncate()
 */
class InvitedPeople extends Model
{
    protected $fillable = ['invitation_id', 'email', 'phone'];

    protected $table = "invited_peoples";

    /**
     * @return array
     */
    public function format(): array
    {
        return [
            'id'            => $this->id,
            'invitation_id' => $this->invitation_id,
            'user_id'       => $this->user_id,
            'email'         => $this->email,
            'phone'         => $this->phone,
        ];
    }

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
