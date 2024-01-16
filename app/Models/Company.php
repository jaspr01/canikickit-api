<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Company
 *
 * @property string $id
 * @property string $name
 * @property string $vatNumber
 * @property string $street
 * @property string $number
 * @property string|null $box
 * @property string $zipCode
 * @property string $city
 * @property string $iban
 * @property string|null $bic
 * @property string|null $bank
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, User> $users
 * @property-read int|null $users_count
 * @method static Builder|Company newModelQuery()
 * @method static Builder|Company newQuery()
 * @method static Builder|Company query()
 * @method static Builder|Company whereBank($value)
 * @method static Builder|Company whereBic($value)
 * @method static Builder|Company whereBox($value)
 * @method static Builder|Company whereCity($value)
 * @method static Builder|Company whereCreatedAt($value)
 * @method static Builder|Company whereIban($value)
 * @method static Builder|Company whereId($value)
 * @method static Builder|Company whereName($value)
 * @method static Builder|Company whereNumber($value)
 * @method static Builder|Company whereStreet($value)
 * @method static Builder|Company whereUpdatedAt($value)
 * @method static Builder|Company whereVatNumber($value)
 * @method static Builder|Company whereZipCode($value)
 * @mixin Eloquent
 */
class Company extends Model
{
    use HasFactory, HasUlids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'vatNumber',
        'street',
        'number',
        'box',
        'zipCode',
        'city',
        'iban',
        'bic',
        'bank',
    ];

    // RELATIONSHIPS

    /**
     * The clients that belong to the company.
     */
    public function clients(): HasMany
    {
        return $this->hasMany(Client::class);
    }

    /**
     * The users that belong to the company.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
