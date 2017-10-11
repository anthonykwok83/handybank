@extends('layouts.app')

@section('content')

    <a href="{{ action('IndexController@index') }}">Back To Home</a>
    <div id="vue-container">
    <h2>Transfer money</h2>

    <p>In this section, I will show you 2 options to use this api</p>

    <p>And you can test</p>
        <ul>
            <li>daily transfer limit of $10000 per account</li>
            <li>To another account from the same owner (No service charge)</li>
            <li>To another account not from the same owner (Fixed service charge of $100 per transfer)</li>
        </ul>

    <ol>
        <li><a href="#curl-way">CURL</a></li>
        <li><a href="#jquery-way">jQuery</a></li>
    </ol>


    <h3>Manipulate custom parameter</h3>

    <label for="user_id">User</label>
    <select name="user_id" id="user_id" v-model="user_id">
        <option value="1">Bank User</option>
        <option value="2">User 1</option>
        <option value="3">User 2</option>
    </select>

    <label for="from_account_id">From Account</label>
    <select name="from_account_id" id="from_account_id" v-model="from_account_id">
        @foreach ($accounts as $account)
            <option value="{{ $account->id }}">Belongs To {{ $account->user->name }}, Bal: {{ $account->balance }}</option>
        @endforeach
    </select>

    <label for="to_account_id">To Account</label>
    <select name="to_account_id" id="to_account_id" v-model="to_account_id">
        @foreach ($accounts as $account)
            <option value="{{ $account->id }}">Belongs To {{ $account->user->name }}, Bal: {{ $account->balance }}</option>
        @endforeach
    </select>

    <br>
    <label for="amount">Amount</label>
    <input id="amount" type="number" min="1" v-model.number="amount">

    <label for="today">Date Of Transaction (YYYY-MM-DD)</label>
    <input type="text" id="today" v-model="today"> <span>👈Please input correctly as no frontend validate included, but backend included😉</span>

    <a id="curl-way"></a>
    <h3>curl</h3>
    <pre v-highlightjs="bashSourceCode"><code class="bash"></code></pre>

    <a id="jquery-way"></a>
    <h3>jQuery</h3>
    <pre v-highlightjs="jsSourceCode"><code class="javascript"></code></pre>

    <p>you may not run from other site due to cross origin issue, but you can try run here 😉👉 <button style="width: 100px;" onclick="tryRun()">Run</button></p>

    </div>
@endsection



@section('footer_js')
    @parent
    <script>
        var data = { user_id: 2, from_account_id: 2, to_account_id: 3, amount: 9000, today: '2017-10-12' };

        function tryRun() {
            $.ajax({
                method: "POST",
                url: "{{ url('/') }}/api/v1/user/" + data.user_id + "/transfer/" + data.from_account_id + "/" + data.to_account_id,
                data: {amount: data.amount, today: data.today}
            }).done(function (response) {
                alert("HTTP Status 200 - " + JSON.stringify(response));
                location.reload();
            }).fail( function(response) {
                alert(response.responseJSON.message);
                alert('Fail to transfer money, May be you can reset database in homepage');
            });
        }
        /*curl -H "X-Requested-With: XMLHttpRequest" -d "amount=9000&today=2017-10-11" -X POST http://handybank.app/api/v1/user/2/transfer/2/3*/

        var vm = new Vue({
            el: '#vue-container',
            data: data,
            computed: {
                bashSourceCode: function () {
                    return "curl -H \"X-Requested-With: XMLHttpRequest\" -d \"amount=" + this.amount + "&today=" + this.today + "\" -X POST {{ url('/') }}/api/v1/user/" + this.user_id + "/transfer/" + this.from_account_id + "/" + this.to_account_id;
                },
                jsSourceCode: function () {
                    return "$.ajax({\n" +
                        "    method: \"POST\",\n" +
                        "    url: \"{{ url('/') }}/api/v1/user/" + this.user_id + "/transfer/" + this.from_account_id + "/" + this.to_account_id + ",\n" +
                        "    data: {amount: " + this.amount + ", today: " + this.today + "}\n" +
                        "}).done(function (response) {\n" +
                        "    alert(\"HTTP Status 200 - \" + JSON.stringify(response));\n" +
                        "    location.reload();\n" +
                        "}).fail( function(response) {\n" +
                        "    alert(response.responseJSON.message);\n" +
                        "    alert('Fail to transfer money, May be you can reset database in homepage');\n" +
                        "});";
                }
            }
        });

    </script>
@endsection