<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'business_id',
        'account_name',
        'account_type',
        'notes',
    ];

    protected $appends = ['balance'];

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function incomes(): HasMany
    {
        return $this->hasMany(Income::class);
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    public function getBalanceAttribute(): float
    {
        return (float) $this->incomes()->sum('amount') - (float) $this->expenses()->sum('amount');
    }
}
