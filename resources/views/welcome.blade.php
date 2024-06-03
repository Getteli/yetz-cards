<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Yetz Cards</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="antialiased">
        <div class="max-w-7xl mx-auto p-6 lg:flex lg:items-center lg:justify-between">
            {{-- user info --}}
            @auth
                <div class="min-w-0 flex-1">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight uppercase  font-light">{{$user->name}} <subtitle class="lowercase ps-1 text-sm text-sky-400/75  font-light">({{$user->email}})</subtitle></h2>
                    <div class="mt-1 flex flex-col sm:mt-0 sm:flex-row sm:flex-wrap sm:space-x-6">
                    <div class="mt-2 flex items-center text-sm text-gray-500" alt="level" title="level">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                        </svg>                      
                        {{$user->level}}
                    </div>
                    <div class="mt-2 flex items-center text-sm text-gray-500" alt="goleiro" title="goleiro">
                        <svg fill="#9ca3af" class="mr-1.5 h-5 w-5 flex-shrink-0 text-gray-400" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 538.043 538.043" xml:space="preserve">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier"><g><path d="M269.022,0C120.689,0,0,120.677,0,269.022s120.689,269.022,269.022,269.022s269.022-120.677,269.022-269.022 S417.354,0,269.022,0z M467.811,124.503h-11.502c-4.962,0-9.35,3.204-10.88,7.915l-24.654,75.876l-64.482,28.337l-75.828-55.084 v-76.043l63.991-46.463c4.017-2.917,5.691-8.083,4.161-12.794l-3.647-11.227C394.804,51.234,437.56,82.99,467.811,124.503z M193.086,35.009l-3.647,11.227c-1.53,4.723,0.143,9.876,4.161,12.794l63.979,46.463v76.043l-75.828,55.084l-64.494-28.349 l-24.666-75.876c-1.53-4.735-5.93-7.915-10.88-7.915H70.232C100.482,82.99,143.251,51.234,193.086,35.009z M22.909,268.83 l9.637,7.007c2.009,1.447,4.364,2.2,6.731,2.2c2.355,0,4.723-0.741,6.731-2.2l63.369-46.045l64.482,28.349l29.257,89.997 l-38.99,46.427H84.568c-4.962,0-9.35,3.204-10.88,7.915l-3.551,10.916c-29.568-40.592-47.24-90.403-47.24-144.375 C22.897,268.95,22.909,268.89,22.909,268.83z M192.894,502.963l9.529-6.959c4.017-2.894,5.703-8.083,4.173-12.781l-24.284-74.692 l38.99-46.403h95.437l38.954,46.403l-24.272,74.704c-1.53,4.723,0.167,9.876,4.185,12.794l9.529,6.935 c-23.985,7.808-49.536,12.196-76.103,12.196C242.442,515.158,216.891,510.794,192.894,502.963z M467.894,413.432l-3.551-10.952 c-1.542-4.723-5.942-7.903-10.892-7.903l-79.547,0.012l-38.954-46.415l29.234-90.008l64.505-28.337l63.358,46.009 c2.009,1.47,4.364,2.212,6.732,2.212c2.367,0,4.735-0.741,6.732-2.212l9.637-6.994c0,0.06,0.012,0.12,0.012,0.191 C515.146,322.993,497.451,372.804,467.894,413.432z"></path></g></g>
                        </svg>
                        @if($user->is_goalkeeper) Sim @else Não @endif
                    </div>
                    <div class="mt-2 flex items-center text-sm text-gray-500" alt="conta criada" title="conta criada">
                        <svg class="mr-1.5 h-5 w-5 flex-shrink-0 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M5.75 2a.75.75 0 01.75.75V4h7V2.75a.75.75 0 011.5 0V4h.25A2.75 2.75 0 0118 6.75v8.5A2.75 2.75 0 0115.25 18H4.75A2.75 2.75 0 012 15.25v-8.5A2.75 2.75 0 014.75 4H5V2.75A.75.75 0 015.75 2zm-1 5.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25v-6.5c0-.69-.56-1.25-1.25-1.25H4.75z" clip-rule="evenodd" />
                        </svg>
                        {{$user->created_at->format('d/m/Y h:i:s')}}
                    </div>
                    </div>
                </div>
            @else
                <div class="min-w-0 flex-1">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight font-light">Poço de caldas - Society</h2>
                </div>
            @endauth
            {{-- routes --}}
            <div class="mt-5 flex lg:ml-4 lg:mt-0">
                @if (Route::has('login'))
                    @auth
                        <span class="">
                            <a href="{{ url('/dashboard') }}" type="button" class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5h3m-6.75 2.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-15a2.25 2.25 0 0 0-2.25-2.25H6.75A2.25 2.25 0 0 0 4.5 4.5v15a2.25 2.25 0 0 0 2.25 2.25Z" />
                                </svg>
                                &nbsp;Dashboard
                            </a>
                        </span>
                    @else
                        <span class="mr-3">
                            <a href="{{ route('login') }}" type="button" class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                                </svg>
                                &nbsp;Login
                            </a>
                        </span>
                        @if (Route::has('register'))
                            <span class="ml-3">
                                <a href="{{ url('/register') }}" type="button" class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                                    </svg>
                                    &nbsp;Registrar
                                </a>
                            </span>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
        
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="w-full">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 text-center mb-5">
                            {{ __('Resultado da última partida') }}
                        </h2>
                    </header>
                    <div class="flex flex-row flex-nowrap justify-center items-center">
                        @if($last_result)
                            <a href="#" class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 mx-3">
                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 text-center">{{$last_result->principal->name}}</h5>
                                <h5 class="text-3xl text-gray-700 text-center">{{$last_result->score_team1}}</h5>
                            </a>
                            <h5 class="text-5xl text-gray-700 text-center">X</h5>
                            <a href="#" class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 mx-3">
                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 text-center">{{$last_result->visitor->name}}</h5>
                                <h5 class="text-3xl text-gray-700 text-center">{{$last_result->score_team2}}</h5>
                            </a>
                        @endif
                    </div>
                </section>
            </div>
        </div>

        <div class="max-w-7xl mx-auto p-6 lg:p-8 bottom-0 absolute">
            <div class="flex justify-center mt-16 px-0 sm:items-center sm:justify-between">
                <div class="text-center text-sm sm:text-left">
                    &nbsp;
                </div>

                <div class="text-center text-sm text-gray-500 dark:text-gray-400 sm:text-right sm:ml-0">
                    Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                </div>
            </div>
        </div>
    </body>
</html>