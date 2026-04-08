<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aspiration extends Model
{
    protected $fillable = [
        'user_id', 'category_id', 'lokasi', 'judul', 'deskripsi', 'photo', 'status'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($aspiration) {
            if ($aspiration->photo) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($aspiration->photo);
            }
        });
    }

    public function pelapor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    public function getLabelLokasiAttribute(): string
    {
        $labels = [
            'ruang_kelas'  => 'Ruang Kelas',
            'toilet'       => 'Toilet',
            'kantin'       => 'Kantin',
            'perpustakaan' => 'Perpustakaan',
            'laboratorium' => 'Laboratorium',
            'lapangan'     => 'Lapangan',
            'mushola'      => 'Mushola',
            'parkiran'     => 'Parkiran',
            'koridor'      => 'Koridor / Lorong',
            'lainnya'      => 'Lainnya',
        ];
        return $labels[$this->lokasi] ?? $this->lokasi;
    }
}
