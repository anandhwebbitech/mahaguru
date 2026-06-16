<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Order extends Model
{
    //
    protected $guarded = []; 

    
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function review()
    {
        return $this->hasOne(Review::class);
    }
    public function products()
    {
        $ids = explode(',', $this->product_id);

        return \App\Models\Product::whereIn('id', $ids)->get();
    }

    

public function shippingAddress()
{
    return $this->belongsTo(CustomAddress::class, 'shiping_address_id', 'id');
}
}
