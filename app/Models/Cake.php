<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cake extends Model
{
    use SoftDeletes;

    protected $table = "cake";

    protected $fillable = ['nome', 'peso', 'qtd_disponivel'];

    public function waitingList()
    {
        return $this->hasMany(WaitingList::class, 'cake_id', 'id');
    }

}
