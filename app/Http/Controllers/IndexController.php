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
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed');
        return redirect()->back();
    }

    public function openAccount()
    {
        return view('doc.open_account');
    }

    public function closeAccount()
    {
        return view('doc.close_account');
    }

    public function getCurrentBalance()
    {
        return view('doc.get_current_balance');
    }

    public function withdrawMoney()
    {
        return view('doc.withdraw_money');
    }

    public function depositMoney()
    {
        return view('doc.deposit_money');
    }

    public function transferMoney()
    {
        return view('doc.transfer_money');
    }
}
