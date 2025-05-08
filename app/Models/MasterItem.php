<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterItem extends Model
{
    protected $fillable = ['category_id', 'kode', 'nama', 'harga_beli', 'laba', 'supplier_id', 'jenis', 'user_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }


}
