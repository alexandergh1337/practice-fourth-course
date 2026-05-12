<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        "user_id",
        "service_id",
        "details",
        "date",
        "time",
        "guests",
        "phone",
        "payment_method",
        "status",
        "cancel_reason",
        "review",
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
