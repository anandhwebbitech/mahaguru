<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    //
    protected $guarded = [];
    protected $casts = [
        'thumbnail' => 'array', 
    ];
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function size()
    {
        return $this->belongsTo(Size::class, 'size_id');
    }

    /**
     * Color ரிலேஷன்ஷிப் 👈 இதையும் சேர்க்கவும்
     */
    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id');
    }
}
