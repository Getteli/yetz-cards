<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Criar jogador(a)') }}
                        </h2>
                    </header>

                    <form method="post" action="{{ route('player.create') }}" class="mt-6 space-y-6">
                        @csrf
                        @method('patch')

                        <div>
                            <x-input-label for="name" :value="__('Nome')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required autofocus autocomplete="name" />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>
                
                        <div>
                            <x-input-label for="level" :value="__('Nível')" />
                            <div class="mt-6 space-y-6">
                                <div class="relative flex gap-x-3">
                                    <input type="number" id="level" name="level" aria-describedby="helper-text-explanation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="1" step="1" min="1" max="5" required />
                                </div>
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('level')" />
                        </div>
                
                        <div>
                            <x-input-label :value="__('Goleiro ?')" />
                            <div class="mt-6 space-y-6">
                                <div class="relative flex gap-x-3">
                                    <div class="flex h-6 items-center">
                                        <input id="is_goalkeeper" name="is_goalkeeper" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                    </div>
                                    <div class="text-sm leading-6">
                                        <label for="is_goalkeeper" class="font-medium text-gray-900">
                                            <p class="text-gray-500">Marque o checkbox se for goleiro.</p>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('is_goalkeeper')" />
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" required autocomplete="email" />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
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