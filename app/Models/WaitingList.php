<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WaitingList extends Model
{
    use SoftDeletes;

    protected $table = "waiting_list";

    protected $fillable = ['email', 'send_email'];

    public function cake()
    {
        return $this->belongsTo(Cake::class, 'id', 'cake_id');
    }
}
