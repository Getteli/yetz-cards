<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 mb-3">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Jogadores') }} ({{$team->users->count()}})
                        </h2>
                    </header>
                    <div class=" w-full flex flex-wrap">
                        @foreach ($team->users as $k => $player)
                            <div class="w-60 h-max">
                                <div class="mt-6 space-y-6">
                                    <div class="relative flex gap-x-3">
                                        <div class="flex h-6 items-center">
                                            <input id="player{{$k}}" name="player[{{$k}}]" type="checkbox" checked class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
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

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <header>
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Atualizar time') }}
                    </h2>
            
                    <p class="mt-1 text-sm text-gray-600">
                        {{ __("Atualize as informações deste time") }}
                    </p>
                </header>

                <form method="post" action="{{ route('team.update') }}" class="mt-6 space-y-6">
                    @csrf
                    @method('patch')

                    <input type="hidden" name="id" id="id" value="{{$team->id}}">
                    <div>
                        <x-input-label for="name" :value="__('Nome')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $team->name)" required autofocus autocomplete="name" />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>
                    <div>
                        <x-input-label :value="__('Ativar')" />
                        <div class="mt-6 space-y-6">
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_active" value="{{$team->is_active}}" class="sr-only peer" @if($team->is_active) checked @endif>
                                <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                <span class="ms-3 text-sm font-medium text-gray-900">Ativo</span>
                            </label>                                  
                        </div>
                        <x-input-error class="mt-2" :messages="$errors->get('is_goalkeeper')" />
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Salvar') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>