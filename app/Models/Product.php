<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'short_description',
        'price',
        'compare_price',
        'cost',
        'sku',
        'barcode',
        'quantity',
        'track_quantity',
        'weight',
        'featured_image',
        'gallery_images',
        'is_featured',
        'is_active',
        'order',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'file_path',
        'file_size',
        'download_limit',
        'access_days',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'compare_price' => 'decimal:2',
        'cost' => 'decimal:2',
        'quantity' => 'integer',
        'track_quantity' => 'boolean',
        'weight' => 'decimal:2',
        'gallery_images' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
            if (empty($product->sku)) {
                $product->sku = 'PRD-' . strtoupper(Str::random(8));
            }
        });

        static::updating(function ($product) {
            if ($product->isDirty('name') && empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    // Relaciones
    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeInStock($query)
    {
        return $query->where(function ($q) {
            $q->where('track_quantity', false)
              ->orWhere('quantity', '>', 0);
        });
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc')->orderBy('created_at', 'desc');
    }

    // Helpers
    public function isInStock(): bool
    {
        if (!$this->track_quantity) {
            return true;
        }
        return $this->quantity > 0;
    }

    public function hasDiscount(): bool
    {
        return $this->compare_price && $this->compare_price > $this->price;
    }

    public function getDiscountPercentage(): int
    {
        if (!$this->hasDiscount()) {
            return 0;
        }
        return round((($this->compare_price - $this->price) / $this->compare_price) * 100);
    }

        public function getFeaturedImageUrl(): string
    {
        if (!$this->featured_image) {
            return asset('images/products/default.jpg');
        }

        $path = public_path('images/products/' . $this->featured_image);

        if (file_exists($path)) {
            return asset('images/products/' . $this->featured_image);
        }

        return asset('images/products/default.jpg');
    }

    public function getGalleryUrls(): array
    {
        if (!$this->gallery_images || !is_array($this->gallery_images)) {
            return [];
        }

        return array_map(function ($image) {
            return asset('images/products/' . $image);
        }, $this->gallery_images);
    }

    public function decreaseStock(int $quantity): void
    {
        if ($this->track_quantity) {
            $this->decrement('quantity', $quantity);
        }
    }

    public function increaseStock(int $quantity): void
    {
        if ($this->track_quantity) {
            $this->increment('quantity', $quantity);
        }
    }

    /**
     * Verifica si el producto es un libro (exento de IVA)
     * Busca en la categoría del producto
     */
    public function isBook()
    {
        if (!$this->category) {
            return false;
        }

        $categoryName = strtolower($this->category->name);
        $categorySlug = strtolower($this->category->slug);

        // Verifica si la categoría es "Libros"
        return $categoryName === 'libros' || $categorySlug === 'libros';
    }
    /**
     * Relación con descargas
     */
    public function downloads()
    {
        return $this->hasMany(ProductDownload::class);
    }

    /**
     * Verificar si el producto tiene archivo PDF
     */
    public function hasFile(): bool
    {
        return !empty($this->file_path) && \Storage::exists($this->file_path);
    }

    /**
     * Obtener URL de descarga (NO usar directamente, usar token)
     */
    public function getFileUrl(): ?string
    {
        if (!$this->hasFile()) {
            return null;
        }

        return \Storage::url($this->file_path);
    }

    /**
     * Obtener tamaño del archivo formateado
     */
    public function getFileSizeFormatted(): ?string
    {
        if (!$this->file_size) {
            return null;
        }

        $units = ['B', 'KB', 'MB', 'GB'];
        $size = $this->file_size;
        $unit = 0;

        while ($size >= 1024 && $unit < count($units) - 1) {
            $size /= 1024;
            $unit++;
        }

        return round($size, 2) . ' ' . $units[$unit];
    }

    /**
     * Crear token de descarga para una orden
     */
    public function createDownloadToken(Order $order, string $email): ProductDownload
    {
        return ProductDownload::create([
            'order_id' => $order->id,
            'product_id' => $this->id,
            'user_email' => $email,
            'download_token' => ProductDownload::generateToken(),
            'max_downloads' => $this->download_limit ?? 3,
            'expires_at' => now()->addDays($this->access_days ?? 365),
        ]);
    }

}
