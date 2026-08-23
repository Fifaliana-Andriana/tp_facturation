<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    //
    protected $fillable = ['client_id', 'number', 'invoice_date', 'total_ht', 'total_ttc', 'status'];

    protected $casts = ['invoice_date' => 'date'];

    public function client(){
        return $this->belongsTo(Client::class);
    }
    public function items(){
        return $this->hasMany(InvoiceItem::class);
    }

    public static function generateNumber(){
        $year = date ('Y');
        $last = self::where('number', 'like', "FACT-$year-%")->max('number');
        $num = $last ? intval(substr($last, -4))+1 : 1;
        return 'FACT-'.$year.'-' .str_pad($num, 4, '0', STR_PAD_LEFT);
    }
}
