<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Client extends Model
{
    use HasFactory, HasUlids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'companyId',
        'name',
        'vatNumber',
        'email',
        'phone',
        'street',
        'number',
        'box',
        'zipCode',
        'city',
    ];

    // RELATIONSHIPS

    /**
     * Get the company that owns the client.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
