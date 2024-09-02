<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Ako je naziv tablice u bazi podataka različit od naziva modela
    protected $table = 'products';

    // Atributi koji su masovno dodijeljeni
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'manufacturer', // Dodaj ovu liniju
    ];

    // Ako koristiš timestamp-e
    public $timestamps = true;
}
