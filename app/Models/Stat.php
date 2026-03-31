<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stat extends Model
{
    use HasFactory;

    protected $fillable = [
        'label',
        'value',
        'target',
        'suffix',
        'duration',
        'step',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'target'    => 'integer',
        'duration'  => 'integer',
        'step'      => 'integer',
        'order'     => 'integer',
    ];

    // ─── Scopes ───────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('id');
    }
}
