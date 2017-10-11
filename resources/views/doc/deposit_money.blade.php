@extends('layouts.app')

@section('content')

    <a href="{{ action('IndexController@index') }}">Back To Home</a>
    <div id="vue-container">
        <h2>Deposit money</h2>

        <p>In this section, I will show you 2 options to use this api</p>

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

        <label for="account_id">Account</label>
        <select name="account_id" id="account_id" v-model="account_id">
            @foreach ($accounts as $account)
                <option value="{{ $account->id }}">Belongs To {{ $account->user->name }}, Bal: {{ $account->balance }}</option>
            @endforeach
        </select>


        <label for="amount">Amount</label>
        <input id="amount" type="number" min="1" v-model.number="amount">


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
        var data = { user_id: 2, account_id: 2, amount: 9000 };

        function tryRun() {
            $.ajax({
                method: "POST",
                url: "{{ url('/') }}/api/v1/user/" + data.user_id + "/account/" + data.account_id + "/deposit",
                data: {amount: data.amount}
            }).done(function (response) {
                alert("HTTP Status 200 - " + JSON.stringify(response));
                location.reload();
            }).fail( function(response) {
                alert(response.responseJSON.message);
                alert('Fail to deposit money, May be you can reset database in homepage');
            });
        }


        var vm = new Vue({
            el: '#vue-container',
            data: data,
            computed: {
                bashSourceCode: function () {
                    return "curl -H \"X-Requested-With: XMLHttpRequest\" -d \"amount=" + this.amount + "\" -X POST {{ url('/') }}/api/v1/user/" + this.user_id + "/account/" + this.account_id + "/deposit";
                },
                jsSourceCode: function () {
                    return "$.ajax({\n" +
                        "    method: \"POST\",\n" +
                        "    url: \"{{ url('/') }}/api/v1/user/" + this.user_id + "/account/" + this.account_id + "/deposit\",\n" +
                        "    data: {amount: " + this.amount + "}\n" +
                        "}).done(function (response) {\n" +
                        "    alert(\"HTTP Status 200 - \" + JSON.stringify(response));\n" +
                        "    location.reload();\n" +
                        "}).fail( function(response) {\n" +
                        "    alert(response.responseJSON.message);\n" +
                        "    alert('Fail to deposit money, May be you can reset database in homepage');\n" +
                        "});";
                }
            }
        });
    </script>
@endsection