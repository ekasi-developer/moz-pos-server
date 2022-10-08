<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property Mpesa $mpesa
 * @property int $transaction_id
 * @property string $transactionID
 * @property string $transactionStatus
 * @property string $thirdPartyReference
 * @property string $serviceProviderCode
 * @property string $transactionDescription
 */
class Transaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'amount',
        'method',
        'status',
        'user_id',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'user',
        'mpesa'
    ];

    /**
     * Get user that made the transaction.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get transaction MPesa details.
     *
     * @return HasOne
     */
    public function mpesa(): HasOne
    {
        return $this->hasOne(Mpesa::class);
    }
}
