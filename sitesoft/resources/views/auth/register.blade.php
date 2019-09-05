@extends('layout')

@section('content')


    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
        {{ csrf_field() }}

        <div class="control-group">
            <b>Регистрация</b>
        </div>


        <div class="control-group{{ $errors->has('name') ? ' error' : '' }}">
            <input type="text" id="inputLogin" name="name" placeholder="Логин" data-cip-id="inputLogin"
                   value="{{ old('name') }}" autocomplete="off">

            @if($errors->has('name'))
                <span class="help-inline">{{ $errors->first('name') }}</span>
            @endif
        </div>



        <div class="control-group{{ $errors->has('password') ? ' error' : '' }}">
            <input type="password" id="inputPassword" name="password" placeholder="Пароль"
                   data-cip-id="inputPassword">
            @if($errors->has('password'))
                <span class="help-inline">{{ $errors->first('password') }}</span>
            @endif
        </div>



        <div class="control-group">
            <input type="password" id="inputPassword2" name="password_confirmation" placeholder="Повторите пароль"
                   data-cip-id="inputPassword2">
            <span class="help-inline hide">Текст ошибки</span>
        </div>
        <div class="control-group">
            <button type="submit" class="btn btn-primary">Отправить</button>
        </div>
    </form>


@endsection
