<?php

namespace Tests\Models;

use Illuminate\Database\Eloquent\Model;
use HibaSabouh\ModelTranslations\Traits\HasTranslations;

class Product extends Model
{
    use HasTranslations;

    protected $table = 'products';
    protected $fillable = ['sku', 'price'];
    protected $translatable = ['name', 'description'];

    protected $casts = [
        'price' => 'decimal:2',
    ];
}