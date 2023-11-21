<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />


        <title>Shawi</title>

        <script>
            // On page load or when changing themes, best to add inline in `head` to avoid FOUC
            if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark')
            }
        </script>

    </head>
    <body class="bg-white dark:bg-gray-900">
        <header class="antialiased">
            <nav class="bg-gray-100 border-gray-200 dark:bg-gray-800">
                <div class="flex flex-wrap justify-between items-center">
                    <div class="flex justify-start items-center bg-white dark:bg-gray-900 h-full w-48">
                        <a href="#" class="flex mr-4 mx-2">
                            <img src="https://emploi.travaillerashawi.ca/images/logoShawi.png" class="mr-3 h-16" alt="Shawinigan Logo" />
                        </a>
                    </div>
                    <div class="flex items-center dark:text-white">
                        {{ __('shawinigan_sso::welcome.title') }}
                    </div>
                    <div class="flex items-center">
                        <button id="theme-toggle" type="button" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5">
                            <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                            <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                        </button>
                    </div>
                </div>
            </nav>
        </header>

        <div class="flex dark:text-white w-full text-center items-center mt-14 flex-col">
            <p>
                {{ __('shawinigan_sso::welcome.top_message') }}
            </p>

            <h3 class="text-3xl font-bold mt-4">
                {{ __('shawinigan_sso::welcome.welcome') }}, {{$user->name}}
            </h3>

            <a class="flex w-full text-center items-center flex-col" href="{{route(config('shawi-sso.dashboardRouteName'))}}">
                <p class="mt-10">
                    {{ __('shawinigan_sso::welcome.continue_as') }} :
                </p>
                <div class="mt-2">
                    <img class="w-16 h-16 rounded-full" src="{{$user->getAdAvatar()}}" alt="user photo">
                </div>
                <p>{{$user->name}}</p>
                <p class="font-bold">{{$user->email}}</p>
            </a>

            <form class="mt-10 dark:text-gray-500" method="POST" action="{{ route('logout') }}">
                @csrf
    
                <a class="flex font-bold" href="{{route('logout')}}"
                        onclick="event.preventDefault();
                                    this.closest('form').submit();">
                    {{ __('shawinigan_sso::welcome.change_profile') }}
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 16">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h11m0 0-4-4m4 4-4 4m-5 3H3a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h3"/>
                    </svg>
            </a>
            </form>

            <a class="flex underline text-gray-800 dark:text-gray-500 mt-10" href="">
                {{ __('shawinigan_sso::welcome.unable_to_connect') }}
                <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 8 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 13 5.7-5.326a.909.909 0 0 0 0-1.348L1 1"/>
                </svg>
            </a>
        </div>



        

<footer class="fixed bottom-0 left-0 z-20 w-full bg-white rounded-lg shadow dark:bg-gray-900 m-4">
    <div class="w-full max-w-screen-xl mx-auto p-4 md:py-8">
        <span class="block text-sm text-gray-500 sm:text-center dark:text-gray-400">
            © {{ __('shawinigan_sso::welcome.all_rights_reserved') }} - 
            <a href="https://shawinigan.ca/" class="hover:underline">Ville de Shawinigan</a>. - 
            <a href="{{config('shawi-sso.privacyPolicyLink')}}">{{ __('shawinigan_sso::welcome.privacy_policy') }}</a>
        </span>
    </div>
</footer>



        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>
        <script>
            var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

// Change the icons inside the button based on previous settings
if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    themeToggleLightIcon.classList.remove('hidden');
} else {
    themeToggleDarkIcon.classList.remove('hidden');
}

var themeToggleBtn = document.getElementById('theme-toggle');

themeToggleBtn.addEventListener('click', function() {

    // toggle icons inside button
    themeToggleDarkIcon.classList.toggle('hidden');
    themeToggleLightIcon.classList.toggle('hidden');

    // if set via local storage previously
    if (localStorage.getItem('color-theme')) {
        if (localStorage.getItem('color-theme') === 'light') {
            document.documentElement.classList.add('dark');
            localStorage.setItem('color-theme', 'dark');
        } else {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('color-theme', 'light');
        }

    // if NOT set via local storage previously
    } else {
        if (document.documentElement.classList.contains('dark')) {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('color-theme', 'light');
        } else {
            document.documentElement.classList.add('dark');
            localStorage.setItem('color-theme', 'dark');
        }
    }
    
});
        </script>
    </body>
</html>
