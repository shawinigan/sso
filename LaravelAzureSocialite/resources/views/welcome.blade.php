<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Shawi</title>

        @vite(['resources/css/app.css','resources/js/app.js'])
    </head>
    <body>
        Bienvenue, {{$user->name}}
        <img src="{{$user->getAdAvatar()}}"/>
        {{$user->email}}

        <a href="{{route('dashboard')}}"> Continuer en tant que {{$user->name}}</a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <a href="{{route('logout')}}"
                    onclick="event.preventDefault();
                                this.closest('form').submit();">
                {{ __('shawinigan_sso::Change profile') }}
        </a>
        </form>

        
    </body>
</html>
