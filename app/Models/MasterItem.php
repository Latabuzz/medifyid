<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class MasterItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'kode',
        'nama',
        'harga_beli',
        'laba',
        'supplier',
        'jenis',
        'foto',
    ];

    protected $appends = [
        'foto_url',
    ];

    public function kategoriItems()
    {
        return $this->belongsToMany(
            KategoriItem::class,
            'kategori_item_master_item',
            'master_item_id',
            'kategori_item_id'
        )->withTimestamps();
    }

    public function getFotoUrlAttribute()
    {
        if (!$this->foto) {
            return null;
        }

        return Storage::disk('public')->url($this->foto);
    }
}
