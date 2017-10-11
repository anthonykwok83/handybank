@extends('layouts.app')

@section('content')

    <a href="{{ action('IndexController@index') }}">Back To Home</a>

    <h2>Transfer money</h2>

    <p>In this section, I will show you 2 options to use this api</p>

    <ol>
        <li><a href="#curl-way">CURL</a></li>
        <li><a href="#jquery-way">jQuery</a></li>
    </ol>

    <a id="curl-way"></a>
    <h3>curl</h3>

    <h4>Transfer money (same account owner)</h4>
    <p>POST method with parameters</p>
    <table width="50%">
        <tr><td>amount:</td><td>9000</td></tr>
        <tr><td>today:</td><td>2017-10-11</td></tr>
    </table>
    <pre>
    <code class="bash">
curl -d "amount=9000&today=2017-10-11" -X POST {{ action('Api\V1\AccountController@transferMoney', ['user' => 2, 'account' => 2, 'toAccount' => 3]) }}
    </code>
    </pre>

    <h4>Transfer money (different account owner)</h4>
    <p>Transfer from account 4 (User 2) to 2 (User 1)</p>
    <p>It will charge fixed service charge $100, Check changing <a href="{{ action('IndexController@index') }}">here</a></p>
    <p>POST method with parameters</p>
    <table width="50%">
        <tr><td>amount:</td><td>9000</td></tr>
        <tr><td>today:</td><td>2017-10-11</td></tr>
    </table>
    <pre>
    <code class="bash">
curl -d "amount=9000&today=2017-10-11" -X POST {{ action('Api\V1\AccountController@transferMoney', ['user' => 3, 'account' => 4, 'toAccount' => 2]) }}
    </code>
    </pre>

    <hr>
    <a id="jquery-way"></a>
    <h3>jQuery</h3>

    <h4>Transfer money (same account owner)</h4>
    <p>POST method with parameters</p>
    <table width="50%">
        <tr><td>amount:</td><td>9000</td></tr>
        <tr><td>today:</td><td>2017-10-11</td></tr>
    </table>
    <pre>
    <code class="javascript">
$.ajax({
    method: "POST",
    url: "{{ action('Api\V1\AccountController@transferMoney', ['user' => 2, 'account' => 2, 'toAccount' => 3]) }}",
    data: {amount: 9000, today: "2017-10-11"}
}).done(function (response) {
    alert("HTTP Status 200 - " + JSON.stringify(response));
}).fail( function() {
    alert('Fail to withdraw money, May be you can reset database in homepage');
});
    </code>
    </pre>
    <p>you may not run from other site, because the cross origin issue, but you can try run here <button style="width: 100px;" onclick="tryRun1()">Run</button></p>

    <h4>Transfer money (different account owner)</h4>
    <p>Transfer from account 4 (User 2) to 2 (User 1)</p>
    <p>It will charge fixed service charge $100, Check changing <a href="{{ action('IndexController@index') }}">here</a></p>
    <p>POST method with parameters</p>
    <table width="50%">
        <tr><td>amount:</td><td>9000</td></tr>
        <tr><td>today:</td><td>2017-10-11</td></tr>
    </table>
    <pre>
    <code class="javascript">
$.ajax({
    method: "POST",
    url: "{{ action('Api\V1\AccountController@transferMoney', ['user' => 3, 'account' => 4, 'toAccount' => 2]) }}",
    data: {amount: 9000, today: "2017-10-11"}
}).done(function (response) {
    alert("HTTP Status 200 - " + JSON.stringify(response));
}).fail( function() {
    alert('Fail to withdraw money, May be you can reset database in homepage');
});
    </code>
    </pre>
    <p>you may not run from other site, because the cross origin issue, but you can try run here <button style="width: 100px;" onclick="tryRun2()">Run</button></p>

@endsection



@section('footer_js')
    @parent
    <script>
        function tryRun1() {
            $.ajax({
                method: "POST",
                url: "{{ action('Api\V1\AccountController@transferMoney', ['user' => 2, 'account' => 2, 'toAccount' => 3]) }}",
                data: {amount: 9000, today: "2017-10-11"}
            }).done(function (response) {
                alert("HTTP Status 200 - " + JSON.stringify(response));
            }).fail( function() {
                alert('Fail to withdraw money, May be you can reset database in homepage');
            });
        }

        function tryRun2() {
            $.ajax({
                method: "POST",
                url: "{{ action('Api\V1\AccountController@transferMoney', ['user' => 3, 'account' => 4, 'toAccount' => 2]) }}",
                data: {amount: 9000, today: "2017-10-11"}
            }).done(function (response) {
                alert("HTTP Status 200 - " + JSON.stringify(response));
            }).fail( function() {
                alert('Fail to withdraw money, May be you can reset database in homepage');
            });
        }
    </script>
@endsection