<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\FuncCall;

class Client extends Model
{
    //
    protected $fillable = ['name', 'email', 'address', 'nif'];

    public Function invoices(){
        return $this->hasMany(Invoice::class);
    }
}
