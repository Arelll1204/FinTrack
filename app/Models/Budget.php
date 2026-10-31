<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'amount',
        'spent',
        'start_date',
        'end_date',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'spent' => 'decimal:2',
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getMonthAttribute(): int
    {
        return $this->start_date ? (int) $this->start_date->month : 0;
    }

    public function getYearAttribute(): int
    {
        return $this->start_date ? (int) $this->start_date->year : 0;
    }
}
