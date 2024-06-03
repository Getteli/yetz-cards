<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg my-3">
                <div class="p-6 text-gray-900">
                    {{ __("Bem vindo jogador!") }}
                </div>
            </div>
            <div class="flex flex-col md:flex-row">

                <div class="relative my-3 md:my-0 flex flex-col w-full h-max md:mx-5 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                  <a href="{{route('player.list')}}">
                    <div class="flex-auto p-4">
                      <div class="flex flex-wrap -mx-3">
                        <div class="flex-none w-1/2 max-w-full px-3">
                          <div>
                            <p class="mb-0 font-sans font-semibold leading-normal text-xl md:text-2xl">Jogadores</p>
                          </div>
                        </div>
                        <div class="w-1/2	max-w-full px-3 ml-auto text-right flex-0">
                          <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500 shadow-soft-2xl">
                            <h3 class="text-4xl text-slate-200">{{$players}}</h3>
                          </div>
                        </div>
                      </div>
                    </div>
                  </a>
                </div>

                <div class="relative my-3 md:my-0 flex flex-col w-full h-max md:mx-5 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                  <a href="{{route('team.list')}}">
                    <div class="flex-auto p-4">
                      <div class="flex flex-wrap -mx-3">
                        <div class="flex-none w-1/2	max-w-full px-3">
                          <div>
                            <p class="mb-0 font-sans font-semibold leading-normal text-xl md:text-2xl">Times</p>
                          </div>
                        </div>
                        <div class="w-1/2	max-w-full px-3 ml-auto text-right flex-0">
                          <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500 shadow-soft-2xl">
                            <h3 class="text-4xl text-slate-200">{{$teams}}</h3>
                          </div>
                        </div>
                      </div>
                    </div>
                  </a>
                </div>

                <div class="relative my-3 md:my-0 flex flex-col w-full md:mx-5 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                  <a href="{{route('team.form')}}">
                    <div class="flex-auto p-4">
                      <div class="flex flex-wrap -mx-3">
                        <div class="flex-none w-full max-w-full px-3">
                          <div>
                            <p class="mb-0 font-sans font-semibold leading-normal text-xl md:text-2xl">Organizar partida</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>