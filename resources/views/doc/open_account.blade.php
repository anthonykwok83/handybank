@extends('layouts.app')

@section('content')

    <a href="{{ action('IndexController@index') }}">Back To Home</a>
    <div id="vue-container">
    <h2>Open Account</h2>

    <p>In this section, I will show you 2 options to use this api</p>

    <ol>
        <li><a href="#curl-way">CURL</a></li>
        <li><a href="#jquery-way">jQuery</a></li>
    </ol>

    <h3>Manipulate custom parameter</h3>

    <label for="user_id">User Account</label>
    <select name="user_id" id="user_id" v-model="user_id">
        <option value="1">Bank User</option>
        <option value="2">User 1</option>
        <option value="3">User 2</option>
    </select>

    <label for="balance">Open Balance</label>
    <input id="balance" type="number" min="1" v-model.number="balance">

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
        var data = { balance: 20000, user_id: 2 };

        function tryRun() {
            $.ajax({
                method: "POST",
                url: "{{ url('/') }}/api/v1/user/" + data.user_id + "/account",
                data: {balance: data.balance}
            }).done(function (response) {
                alert("HTTP Status 200 - " + JSON.stringify(response));
            }).fail( function() {
                alert('Fail to Open account');
            });
        }

        var vm = new Vue({
            el: '#vue-container',
            data: data,
            computed: {
                bashSourceCode: function () {
                    return 'curl -H "X-Requested-With: XMLHttpRequest" -d "balance=' + this.balance + '" -X POST {{ url('/') }}/api/v1/user/' + this.user_id + '/account';
                },
                jsSourceCode: function () {
                    return "$.ajax({\n" +
                        "    method: \"POST\",\n" +
                        "    url: \"{{ url('/') }}/api/v1/user/" + this.user_id + "/account\",\n" +
                        "    data: {balance: " + this.balance + "}\n" +
                        "}).done(function (response) {\n" +
                        "    alert(\"HTTP Status 200 - \" + JSON.stringify(response));\n" +
                        "}).fail( function() {\n" +
                        "    alert('Fail to Open account');\n" +
                        "});";
                }
            }
        });

    </script>
@endsection