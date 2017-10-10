<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Account
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $user_id
 * @property float $balance
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Account onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Account whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Account whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Account whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Account whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Account whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Account whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Account withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Account withoutTrashed()
 * @property-read \App\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\TransactionHistory[] $transactions
 */
class Account extends Model
{
    use SoftDeletes;

    const TRANSFER_LIMIT_AMOUNT_DAILY = 10000;

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'balance'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(TransactionHistory::class);
    }

}
