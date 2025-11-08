<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

        static::updating(function ($category) {
            if ($category->isDirty('name') && empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    // Relaciones
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc')->orderBy('name', 'asc');
    }

    // Helpers
    public function getImageUrl(): string
    {
        if (!$this->image) {
            return asset('images/categories/default.jpg');
        }

        $paths = [
            public_path('images/categories/' . $this->image),
            public_path($this->image)
        ];

        foreach ($paths as $path) {
            if (file_exists($path)) {
                return asset(str_replace(public_path(), '', $path));
            }
        }

        return asset('images/categories/default.jpg');
    }
}
