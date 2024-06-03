<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Resultado da partida') }}
                        </h2>
                    </header>

                    <form method="post" action="{{ route('log_team.create') }}" class="mt-6 space-y-6 flex flex-col">
                        @csrf
                        @method('patch')

                        <div class="w-full flex flex-row">
                            <div class="w-1/2">
                                <x-input-label for="mandante" :value="__('Mandante')" />
                                <div class="mt-6 space-y-6 w-25">
                                    <div class="relative flex gap-x-3">
                                        <select id="mandante" name="mandante" aria-describedby="helper-text-explanation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                                            @foreach ($teams as $team)
                                                <option value="{{$team->id}}">{{$team->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('mandante')" />
                            </div>

                            <div class="w-2/5 ms-0 md:ms-3">
                                <x-input-label for="gols1" :value="__('Gols')" />
                                <div class="mt-6 space-y-6">
                                    <div class="relative flex gap-x-3">
                                        <input type="number" id="gols1" name="gols1" aria-describedby="helper-text-explanation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="1" step="1" min="1" max="5" required />
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('gols1')" />
                            </div>
                        </div>

                        <div class="w-full flex flex-row">
                            <div class="w-1/2">
                                <x-input-label for="visitor" :value="__('Visitante')" />
                                <div class="mt-6 space-y-6">
                                    <div class="relative flex gap-x-3">
                                        <select id="visitor" name="visitor" aria-describedby="helper-text-explanation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                                            @foreach ($teams as $team)
                                                <option value="{{$team->id}}">{{$team->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('visitor')" />
                            </div>
                            <div class="w-2/5 ms-0 md:ms-3">
                                <x-input-label for="gols2" :value="__('Gols')" />
                                <div class="mt-6 space-y-6">
                                    <div class="relative flex gap-x-3">
                                        <input type="number" id="gols2" name="gols2" aria-describedby="helper-text-explanation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="1" step="1" min="1" max="5" required />
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('gols2')" />
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Salvar') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>