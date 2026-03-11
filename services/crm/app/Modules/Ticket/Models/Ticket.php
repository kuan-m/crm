<?php

namespace App\Modules\Ticket\Models;

use App\Enums\DiskName;
use App\Modules\Customer\Models\Customer;
use App\Modules\Ticket\Enums\TicketMediaCollection;
use Database\Factories\TicketFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * Class Ticket
 *
 * @property int $id
 * @property int $customer_id
 * @property string $subject
 * @property string $text
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $replied_at
 */
class Ticket extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\TicketFactory> */
    use HasFactory, InteractsWithMedia;

    protected static function newFactory()
    {
        return TicketFactory::new();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(TicketMediaCollection::ATTACHMENTS->value)
            ->useDisk(DiskName::TICKETS_ATTACHMENTS->value);
    }

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_id',
        'subject',
        'text',
        'status',
        'replied_at',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'replied_at' => 'datetime',
    ];

    /**
     * @return BelongsTo<Customer, $this>
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
