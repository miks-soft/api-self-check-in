<?php

namespace App\Models;

use App\Enums\AgeEnum;
use App\Enums\PaymentEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'booking';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'service_id',
        'date_from',
        'date_to',
        'duration',
        'name',
        'last_name',
        'phone',
        'email',
        'age',
        'flight',
        'departure',
        'payment',
        'count',
        'price',
        'total',
        'currency',
        'is_paid',
        'gettsleep_id',
        'gettsleep_status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'age' => AgeEnum::class,
        'payment' => PaymentEnum::class,
    ];

    /**
     * @return BelongsTo
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * @return HasMany
     */
    public function additional(): HasMany
    {
        return $this->hasMany(BookingAdditionalService::class);
    }
}
