<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Artículos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="flex justify-between">
                        <h1 class="text-2xl mb-2">
                            Todos los artículos
                        </h1>
                        <a href="{{ route('articles.add') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                            Agregar
                        </a>
                    </div>

                    <div class="relative overflow-x-auto mt-3">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Nombre
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Cantidad
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Precio
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Propietario
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($articles as $article)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            <p>{{ $article->name }}</p>
                                            <small>{{ $article->description }}</small>
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ $article->amount }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{$article->price}}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{$article->user->name}}
                                        </td>
                                        <td>
                                            <x-link-primary-button class="ms-3" href="{{ route('articles.show', $article->id) }}" >
                                                Ver
                                            </x-link-primary-button>
                                            <x-primary-button class="ms-3">
                                                Editar
                                            </x-primary-button>
                                            <x-primary-button class="ms-3">
                                                Eliminar
                                            </x-primary-button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <td colspan="5" class="text-center px-6 py-4">
                                            Aún no hay artículos registrados
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>
