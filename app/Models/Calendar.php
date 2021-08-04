<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Calendar extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'client_id',
        'valor',
        'data',
        'observacao'
    ];

    protected $dates = ['deleted_at', 'data'];

    public function client()
    {
        return $this->hasOne(Client::class, 'id', 'client_id');
    }
}
