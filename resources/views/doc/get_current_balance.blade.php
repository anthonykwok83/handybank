@extends('layouts.app')

@section('content')

    <a href="{{ action('IndexController@index') }}">Back To Home</a>

    <h2>Get current balance</h2>

    <p>In this section, I will show you 2 options to use this api</p>

    <ol>
        <li><a href="#curl-way">CURL</a></li>
        <li><a href="#jquery-way">jQuery</a></li>
    </ol>

    <a id="curl-way"></a>
    <h3>curl</h3>

    <pre>
        <code class="bash">
curl {{ action('Api\V1\AccountController@show', ['user' => 2, 'account' => 2]) }}
        </code>
    </pre>

    <a id="jquery-way"></a>
    <h3>jQuery</h3>

<pre><code class="javascript">
$.ajax({
    method: "GET",
    url: "{{ action('Api\V1\AccountController@show', ['user' => 2, 'account' => 2]) }}"
}).done(function (response) {
    alert("HTTP Status 200 - " + JSON.stringify(response));
}).fail( function() {
    alert('Fail to check current balance, May be you can reset database in homepage');
});
    </code></pre>
    <p>you may not run from other site, because the cross origin issue, but you can try run here <button style="width: 100px;" onclick="tryRun()">Run</button></p>


@endsection



@section('footer_js')
    @parent
    <script>
        function tryRun() {
            $.ajax({
                method: "GET",
                url: "{{ action('Api\V1\AccountController@show', ['user' => 2, 'account' => 2]) }}"
            }).done(function (response) {
                alert("HTTP Status 200 - " + JSON.stringify(response));
            }).fail( function() {
                alert('Fail to check current balance, May be you can reset database in homepage');
            });
        }
    </script>
@endsection