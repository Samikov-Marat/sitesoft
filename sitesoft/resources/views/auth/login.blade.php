@extends('layout')

@section('content')

    @if($errors->isNotEmpty())
        <div class="alert alert-error">
            Вход в систему с указанными данными невозможен
        </div>
    @endif

    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
        {{ csrf_field() }}
        <div class="control-group">
            <b>Авторизация</b>
        </div>
        <div class="control-group">
            <input type="text" id="inputLogin" name="name" value="{{ old('name') }}" placeholder="Логин"
                   data-cip-id="inputLogin"
                   autocomplete="off">
        </div>
        <div class="control-group">
            <input type="password" id="inputPassword" name="password" placeholder="Пароль"
                   data-cip-id="inputPassword">
        </div>
        <div class="control-group">
            <label class="checkbox">
                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} value="1"> Запомнить меня
            </label>
            <button type="submit" class="btn btn-primary">Вход</button>
        </div>
    </form>

@endsection



