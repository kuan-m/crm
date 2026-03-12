<?php

namespace App\Modules\Customer\Models;

use App\Modules\Ticket\Models\Ticket;
use Database\Factories\CustomerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string $phone
 * @property string $email
 */
class Customer extends Model
{
    /** @use HasFactory<\Database\Factories\CustomerFactory> */
    use HasFactory;

    protected static function newFactory()
    {
        return CustomerFactory::new();
    }

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'phone',
        'email',
    ];

    /**
     * @return HasMany<Ticket, $this>
     */
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }
}
