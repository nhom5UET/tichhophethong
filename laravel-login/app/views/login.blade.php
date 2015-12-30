

@extends("main")
@section('title')
    Login
@endsection

@section('content')
    <form method="post" action="{{Asset('welcome')}}" id="form-login">
        <h2>Login</h2>
        <input type="text" name="user_input" id="user_input" placeholder="Username or Email" class="form-control"/>
        <input type="password" name="password" id="password" placeholder="Password" class="form-control"/>
        <button class="btn btn-lg btn-primary btn-block">Login</button>
    </form>
@endsection

