@extends('layouts.app')

@section('content')

    <a href="{{ action('IndexController@index') }}">Back To Home</a>

    <h2>Deposit money</h2>

    <p>In this section, I will show you 2 options to use this api</p>

    <ol>
        <li><a href="#curl-way">CURL</a></li>
        <li><a href="#jquery-way">jQuery</a></li>
    </ol>

    <a id="curl-way"></a>
    <h3>curl</h3>

    <code class="source-code">
curl -H "X-Requested-With: XMLHttpRequest" -d "amount=9000" -X POST {{ action('Api\V1\AccountController@deposit', ['user' => 2, 'account' => 2]) }}
    </code>

    <a id="jquery-way"></a>
    <h3>jQuery</h3>
    <pre><code class="javascript">
$.ajax({
    method: "POST",
    url: "{{ action('Api\V1\AccountController@deposit', ['user' => 2, 'account' => 2]) }}",
    data: {amount: 9000}
}).done(function (response) {
    alert("HTTP Status 200 - " + JSON.stringify(response));
}).fail( function() {
    alert('Fail to withdraw money, May be you can reset database in homepage');
});
    </code></pre>

    <p>you may not run from other site, because the cross origin issue, but you can try run here <button style="width: 100px;" onclick="tryRun()">Run</button></p>

@endsection


@section('footer_js')
    @parent
    <script>
        function tryRun() {
            $.ajax({
                method: "POST",
                url: "{{ action('Api\V1\AccountController@deposit', ['user' => 2, 'account' => 2]) }}",
                data: {amount: 9000}
            }).done(function (response) {
                alert("HTTP Status 200 - " + JSON.stringify(response));
            }).fail( function() {
                alert('Fail to withdraw money, May be you can reset database in homepage');
            });
        }
    </script>
@endsection