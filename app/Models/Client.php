<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'nome',
        'endereco',
        'bairro',
        'cidade',
        'uf',
        'cep',
        'fone',
        'data_nascimento',
        'data_adesao',
        'referencia'
    ];

    protected $dates = ['deleted_at', 'data_nascimento', 'data_adesao'];

    public function agendamentos()
    {
        return $this->hasMany('App\Models\Calendar', 'client_id', 'id');
    }
}
