<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Organizar partida') }}
                        </h2>

                        <p class="mt-1 text-sm text-gray-600">
                            {{ __("Selecione os jogadores que confirmaram presença") }}
                        </p>
                    </header>
                </div>
            </div>
        </div>

        <form method="post" action="{{ route('team.create') }}" class="mt-6 space-y-6">
            @csrf
            @method('patch')

            {{-- seleciona os jogadores presentes --}}
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 mt-3">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <h4 class="text-lg font-medium text-gray-900">
                        {{ __('Jogadores') }}
                    </h4>
                    <div class=" w-full flex flex-wrap">
                        @foreach ($players as $k => $player)
                            <div class="w-60 h-max">
                                <div class="mt-6 space-y-6">
                                    <div class="relative flex gap-x-3">
                                        <div class="flex h-6 items-center">
                                            <input id="player{{$k}}" name="player[{{$k}}]" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600" value="{{$player->id}},{{$player->level}}">
                                        </div>
                                        <div class="text-sm leading-6">
                                            <label for="player{{$k}}" class="font-medium text-gray-900">
                                                <p class="text-gray-500">{{$player->name}} @if($player->is_goalkeeper) (Goleiro) @endif</p>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('player')" />
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- quantidade jogadores por time --}}
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 mt-3">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <header>
                            <p class="mt-1 text-sm text-gray-600">
                                {{ __("Escolha a quantidade de jogadores por time") }}
                            </p>
                            <b class="mt-1 text-sm text-gray-900">
                                {{ __("obs: Se houver mais de dois times completos, o último time ficará com o
                                número de jogadores menor do que aquele definido.") }}
                            </b>
                        </header>
                        <div class="my-3">
                            <x-input-label for="nj" :value="__('Jogadore por time')" />
                            <div class="mt-6 space-y-6">
                                <div class="relative flex gap-x-3">
                                    <input type="number" id="nj" name="nj" aria-describedby="helper-text-explanation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="8" step="1" min="3" required />
                                </div>
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('nj')" />
                        </div>

                        <div class="flex items-center gap-4 mt-5">
                            <x-primary-button>{{ __('Criar partida') }}</x-primary-button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>