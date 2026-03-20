<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory; 
    
    protected $guarded = [];

    /**
     * Relasi ke model Category
     * Satu produk hanya memiliki satu kategori
     */
    public function category() {
        return $this->belongsTo(Category::class);
    }
    
    /**
     * Relasi ke model StockTotal
     * Satu produk memiliki satu total stok
     */
    public function stockTotal() {
        return $this->hasOne(StockTotal::class);
    }
    
    /**
     * Aksesors untuk mendapatkan URL gambar produk 
     */
    public function image() {
        return Attribute::make(
            get: fn($image) => url('/storage/products'. $image),
        );
    }



}