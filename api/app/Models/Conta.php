<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class Conta extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $fillable = [
        'id_banco',
        'id_forma_pagamento',
        'valor',
        'tipo'
    ];

    protected $casts = [
        'created_at'  => 'datetime:d/m/Y H:i:s',
    ];

    public function saldo()
    {
        $total = 0;

        foreach ($this->all() as $valor) {
            if ($valor['tipo'] == 'ENTRADA') {
                $total += $valor['valor'];
            } else if ($valor['tipo'] == 'SAIDA') {
                $total -= $valor['valor'];
            }
        }

        return ['saldo' => $total];
    }


    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
}
