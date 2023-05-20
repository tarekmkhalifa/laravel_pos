<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Product extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    public $translatedAttributes = ['name', 'description'];

    protected $fillable = [
        'purchase_price',
        'sale_price',
        'stock',
        'image',
        'category_id'
    ];

    protected $appends = ['profit_percent'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getProfitPercentAttribute()
    {
        $profit = $this->sale_price - $this->purchase_price;
        $profit_percent = ($profit * 100) / $this->purchase_price;
        return number_format($profit_percent, 2);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class,'product_order');
    }

}
