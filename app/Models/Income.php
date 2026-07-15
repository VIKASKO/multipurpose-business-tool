<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Income extends Model
{
    use HasFactory, SoftDeletes, \App\Traits\HasCreator;

    protected $fillable = [
        'business_id',
        'source_id',
        'account_id',
        'date',
        'amount',
        'description',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function source(): BelongsTo
    {
        return $this->belongsTo(IncomeSource::class, 'source_id');
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
