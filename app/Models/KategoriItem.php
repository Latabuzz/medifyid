<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'kode',
    ];

    public function masterItems()
    {
        return $this->belongsToMany(
            MasterItem::class,
            'kategori_item_master_item',
            'kategori_item_id',
            'master_item_id'
        )->withTimestamps();
    }
}
