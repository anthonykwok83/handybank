@extends('layouts.app')

@section('content')

    <h2>Create a set of API using PHP to simulate the functionality of a basic bank account:</h2>

    <p>First thing first, I created the repository in github</p>
    <a href="https://github.com/anthonykwok83/handybank">https://github.com/anthonykwok83/handybank</a>
    <p>You may pull it to local and see the source code</p>
    <p>Then, we have to generate the tables for keep track all the things</p>
    <p>You may run</p>
    <pre><code class="bash">php artisan migrate:refresh --seed</code></pre>
    <p>to generate your own</p>

    <p>To keep this api project simple and easy to read. I decided not to use any frontend framework such as bootstrap and datatables</p>

    <p>So I will present the raw html tables here. Please refresh this page manually to see the changing after using the api</p>

    <hr>
    <h3>Here are the tasks implemented</h3>

    <ol>
        <li><a href="{{ action('IndexController@openAccount') }}">Open account</a></li>
        <li><a href="{{ action('IndexController@closeAccount') }}">Close account</a></li>
        <li><a href="{{ action('IndexController@getCurrentBalance') }}">Get current balance</a></li>
        <li><a href="{{ action('IndexController@withdrawMoney') }}">Withdraw money</a></li>
        <li><a href="{{ action('IndexController@depositMoney') }}">Deposit money</a></li>
        <li><a href="{{ action('IndexController@transferMoney') }}">Transfer money</a></li>
    </ol>

    <hr>
    <h4>User table</h4>
    <table class="user-table" border="1">
        <tr>
            <td>id</td>
            <td>name</td>
            <td>email</td>
            <td>is bank owner</td>
        </tr>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->is_bank_owner ? 'yes' : 'no' }}</td>
            </tr>
        @endforeach
    </table>


    <h4>Account table</h4>
    <table class="account-table" border="1">
        <tr>
            <td>account id</td>
            <td>user id (belongs to)</td>
            <td>balance</td>
        </tr>
        @foreach ($accounts as $account)
            <tr>
                <td>{{ $account->id }}</td>
                <td>{{ $account->user_id }} ( {{ $account->user->name }} )</td>
                <td>{{ $account->balance }}</td>
            </tr>
        @endforeach
    </table>


    <h4>Transaction History table</h4>
    <table class="transaction-history-table" border="1">
        <tr>
            <td>id</td>
            <td>account id</td>
            <td>flow type</td>
            <td>amount</td>
            <td>remark</td>
            <td>transaction at</td>
        </tr>
        @foreach ($transactionHistories as $transactionHistory)
            <tr>
                <td>{{ $transactionHistory->id }}</td>
                <td>{{ $transactionHistory->account_id }}</td>
                <td>{{ $transactionHistory->flow_type }}</td>
                <td>{{ $transactionHistory->amount }}</td>
                <td>{{ $transactionHistory->remark }}</td>
                <td>{{ $transactionHistory->transaction_at }}</td>
            </tr>
        @endforeach
    </table>

    <hr>
    <h3>Reset database to factory mode</h3>
    <form action="{{ action('IndexController@resetDatabase') }}" method="post">
        {{ csrf_field() }}
        <input type="submit" value="Reset Database" />
    </form>
    



@endsection

@section('footer_js')
    @parent
    <script>hljs.initHighlightingOnLoad();</script>
@endsection