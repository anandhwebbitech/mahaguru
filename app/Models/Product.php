<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    //
    protected $guarded = [];
    
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id');
    }
    public function sizes()
    {
        return $this->belongsTo(Size::class, 'size_id');
    }

    public function colors()
    {
        return $this->belongsTo(Color::class, 'color_id');
    }
    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'product_id'); 
    }
}
