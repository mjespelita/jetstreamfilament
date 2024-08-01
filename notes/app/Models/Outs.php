<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outs extends Model
{
    use HasFactory;

    protected $fillable = ['product', 'receipt_number', 'name', 'quantity'];

    public function products()
    {
        return $this->belongsTo(Stocks::class, 'product');
    }
}
