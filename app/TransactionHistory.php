<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\TransactionHistory
 *
 * @property int $id
 * @property int $account_id
 * @property string $flow_type
 * @property float $amount
 * @property string $remark
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TransactionHistory whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TransactionHistory whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TransactionHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TransactionHistory whereFlowType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TransactionHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TransactionHistory whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TransactionHistory whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Account $account
 * @property string $transaction_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TransactionHistory whereTransactionAt($value)
 */
class TransactionHistory extends Model
{
    const FLOW_SEND = 'SEND';
    const FLOW_RECEIVED = 'RECEIVED';

    protected $dates = [
        'transaction_at',
    ];

    protected $fillable = [
        'flow_type',
        'amount',
        'remark',
        'transaction_at',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }


    /**
     * @param Account $account
     * @param Carbon $date
     * @return double
     */
    public static function getTransferAmountUsedQuotaByAccount(Account $account, Carbon $date)
    {
        $usedQuota = TransactionHistory::where('account_id', '=', $account->id)
            ->where('flow_type', '=', self::FLOW_SEND)
            ->where('account_id', '=', $account->id)
            ->whereDate('transaction_at', '=', $date)
            ->sum('amount');
        return (double) $usedQuota;
    }
}
