<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    use HasFactory;
    protected $guarded = [];

    public function place() {
        return $this->hasOne(Place::class,'place_id','id');
    }

    public function user() {
        return $this->hasOne(User::class);
    }

}
