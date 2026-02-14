<?php

namespace Tests\Models\Translations;

use Illuminate\Database\Eloquent\Model;

class ProductTranslation extends Model
{
    protected $table = 'product_translations';
    protected $fillable = ['lang', 'name', 'description', 'product_id'];
    public $timestamps = false;
}
