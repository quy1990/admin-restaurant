<?php
namespace App\Traits;

use App\Models\Invitation;
use App\Models\People;
use App\Models\Reservation;
use App\Models\Restaurant;
use App\Models\User;

trait UserTrait{

    public function isSuperAdmin(): bool
    {
        return $this->user_type_id == 10;
    }

    public function hasRight(): bool
    {
        return $this->user_type_id > 5;
    }

    public function hasVerifiedEmail()
    {
        return true;
    }

}
