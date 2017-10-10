<?php

namespace App\Http\Controllers\Api\V1;

use App\Account;
use App\Http\Requests\AccountRequest;
use App\TransactionHistory;
use App\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DB;
use \Carbon\Carbon;

class AccountController extends Controller
{
    /**
     * List of Account of specific user
     *
     * @param User $user
     * @return \App\Account[]|Collection
     */
    public function index(User $user)
    {
        return $user->accounts;
    }

    /**
     * Create a Account of specific user
     *
     * @param User $user
     * @param Request $request
     * @return array
     */
    public function store(User $user, Request $request)
    {
        $request->validate([
            'balance' => 'required|numeric',
        ]);

        $account = $user->accounts()->create($request->all());
        if (!is_null($account)) {
            return ['status' => 'success'];
        }

    }

    /**
     * Check Account Balance
     *
     * @param User $user
     * @param Account $account
     * @return Account
     */
    public function show(User $user, Account $account)
    {
        return $account;
    }


    /**
     * Close Account and user may withdraw all the money at the same time
     *
     * @param User $user
     * @param Account $account
     * @return array
     */
    public function destroy(User $user, Account $account)
    {
        $deleted = $account->delete();
        if ($deleted) {
            return ['status' => 'success'];
        }
        abort(503);
    }

    public function withdraw(User $user, Account $account, Request $request)
    {
        $isWithdraw = true;
        return $this->creditDebit($account, $request, $isWithdraw);

    }

    public function deposit(User $user, Account $account, Request $request)
    {
        $isWithdraw = false;
        return $this->creditDebit($account, $request, $isWithdraw);
    }

    /**
     * @param Account $account
     * @param Request $request
     * @param $isDebit
     * @return array
     */
    private function creditDebit(Account $account, Request $request, $isDebit): array
    {
        $request->validate([
            'amount' => 'required|numeric'
        ]);

        $amount = $request->get('amount', 0);

        if ($isDebit) {
            $account->balance -= $amount;
        } else {
            $account->balance += $amount;
        }

        $saved = $account->save();

        if ($saved) {
            return ['status' => 'success'];
        }
        abort(503);
    }


    /**
     * daily transfer limit of $10000 per account (use transaction_history table for help)
     * Transfer to other owner charge Service fee and send $100 to bank account
     *
     *
     * @param User $user
     * @param Account $fromAccount
     * @param Account $toAccount
     * @param Request $request
     * @return array
     */
    public function transferMoney(User $user, Account $fromAccount, Account $toAccount, Request $request)
    {
        // same account return error
        if ($fromAccount->id === $toAccount->id) {
            abort(503);
        }

        // check post with amount parameter, return 442 status code when not pass
        $request->validate([
            // limit amount between 0 to 10000
            'amount' => 'required|numeric|between:0,'. Account::TRANSFER_LIMIT_AMOUNT_DAILY,
            'today' => 'required|date', // for demonstration only, should change back to real today in production
        ]);

        $amount = $request->get('amount');
        // TODO: Anthony for demonstration only, should change back to real today in production
        $today = new Carbon($request->get('today'));

        // if 0 amount transfer, reject and do nothing
        if ($amount == 0) {
            abort(422, 'You are transferring 0 amount to other account');
        }

        // lazy load the relation of the account owner for checking the same user.
        $fromAccount->load(['user', 'transactions']);
        $toAccount->load('user');

        $quota = TransactionHistory::getTransferAmountUsedQuotaByAccount($fromAccount, $today);
        if (($quota + $amount) >= Account::TRANSFER_LIMIT_AMOUNT_DAILY) {
            abort(422, 'Cannot transfer money more than $10000 daily');
        }

        // account has not enough money to transfer
        if ($fromAccount->balance < $amount) {
            abort(422, 'You account has not enough money to transfer');
        }

        // Bank itself no need to take the fixed service charge of $100 per transfer
        DB::beginTransaction();
        $isSuccess = false;
        try {
            $fromAccount->balance -= $amount;
            $toAccount->balance += $amount;

            $fromAccount->save();
            $toAccount->save();

            // Write log to transaction history
            $fromAccount->transactions()->create([
                'flow_type' => TransactionHistory::FLOW_SEND,
                'amount' => $amount,
                'transaction_at' => $today,
                'remark' => "Transfer money from $fromAccount->id to $toAccount->id",
            ]);


            if ($fromAccount->user->id != $toAccount->user->id) {
                $this->serviceChargeToBank($fromAccount);
            }
            DB::commit();
            $isSuccess = true;
        } catch (\Exception $ex) {
            DB::rollBack();
        }


        if ($isSuccess) {
            return ['status' => 'success'];
        } else {
            return ['status' => 'fail'];
        }

    }


    /**
     * Should include transaction if using with other sql
     *
     * @param Account $payer it should be the payer of account and not payee
     */
    private function serviceChargeToBank(Account $payer)
    {
        $bankAccount = $this->getBankAccount();
        $payer->balance -= 100;
        $bankAccount->balance += 100;
        $payer->save();
        $bankAccount->save();
    }


    private function getBankAccount(): Account
    {
        $bankAccount = Account::whereHas('user', function ($query) {
            $query->where('is_bank_owner', '=' , true);
        })->first();
        return $bankAccount;
    }


}
