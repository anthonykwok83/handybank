<?php

namespace App\Http\Controllers;

use App\Account;
use App\TransactionHistory;
use App\User;
use Illuminate\Http\Request;
use Artisan;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        $accounts = Account::all();

        $transactionHistories = TransactionHistory::all();

        return view('demonstrate_api', compact('users', 'accounts', 'transactionHistories'));
    }

    public function resetDatabase()
    {
        Artisan::call('migrate:refresh', ['--force' => true]);
        Artisan::call('db:seed', ['--force' => true]);
        return redirect()->back();
    }

    public function openAccount()
    {
        return view('doc.open_account');
    }

    public function closeAccount()
    {
        $accounts = Account::all();
        return view('doc.close_account', compact('accounts'));
    }

    public function getCurrentBalance()
    {
        $accounts = Account::all();
        return view('doc.get_current_balance', compact('accounts'));
    }

    public function withdrawMoney()
    {
        $accounts = Account::all();
        return view('doc.withdraw_money', compact('accounts'));
    }

    public function depositMoney()
    {
        $accounts = Account::all();
        return view('doc.deposit_money', compact('accounts'));
    }

    public function transferMoney()
    {
        $accounts = Account::all();
        return view('doc.transfer_money', compact('accounts'));
    }
}
