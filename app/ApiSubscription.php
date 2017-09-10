<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApiSubscription extends Model
{
    protected $table = 'api_subscriptions';

    public function getState () {
        if ($this->state === 1) {
            return "ACTIVE";
        } elseif ($this->state === 2) {
            return "REVOKED";
        }

        return "REVOKED";
    }
}
