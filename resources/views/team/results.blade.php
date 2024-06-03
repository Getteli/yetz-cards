<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center gap-4 ms-5 mb-3">
                <a href="{{route('log_team.form')}}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150" type="button">{{ __('Resultado da partida') }}</a>
            </div>

            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Mandante
                            </th>
                            <th scope="col" class="px-6 py-3">
                                resultado
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <b>X</b>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                resultado
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Visitante
                            </th>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Data da partida
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($results as $result)
                            <tr class="bg-white border-b">
                                <th scope="row" class="px-6 py-3 font-medium @if($result->score_team1 > $result->score_team2) text-green-700 @else text-red-700 @endif whitespace-nowrap">
                                    {{$result->principal->name}}
                                </th>
                                <td class="px-6 py-3">
                                    {{$result->score_team1}}
                                </td>
                                <td class="px-6 py-3">
                                    -
                                </td>
                                <td class="px-6 py-3">
                                    {{$result->score_team2}}
                                </td>
                                <th scope="row" class="px-6 py-3 font-medium @if($result->score_team2 > $result->score_team1) text-green-700 @else text-red-700 @endif whitespace-nowrap">
                                    {{$result->visitor->name}}
                                </th>
                                <td class="px-6 py-3">
                                    {{$result->created_at->format('d/m/Y H:i:s')}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>