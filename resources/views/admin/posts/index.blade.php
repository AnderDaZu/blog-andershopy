<x-admin-layout>

    <h1 class="text-base sm:text-lg md:text-xl uppercase font-bold mb-4">Lista de Posts</h1>

    <div class="flex justify-between mb-4">
        <button onclick="cambiarEstilo()" class="focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900"><i class="fa-solid fa-palette"></i> Cambiar estilo</button>

        <x-cstm_button_create href="{{ route('admin.posts.create') }}">
            Agregar Post
        </x-cstm_button_create>
    </div>

    <div id="show_1" class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Imagen
                    </th>
                    <th scope="col" class="px-6 py-3 max-w-96">
                        Título
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Extracto
                    </th>
                    <th scope="col" colspan="2" class="px-6 pl-2 pr-6">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($posts as $post)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.posts.edit', $post) }}">
                                <img src="{{ $post->image_path }}" alt="{{ $post->title }}" class="aspect-[16/9] object-cover object-center rounded h-32 max-w-44">
                            </a>
                        </td>
                        <th class="px-6 py-4 font-medium text-gray-900 dark:text-white text-sm sm:text-lg">
                            <a href="{{ route('admin.posts.edit', $post) }}" class="text-base md:text-lg block">
                                {{ $post->title }}
                            </a>
                            <hr class="my-2">
                            <span @class([
                                'bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300' => $post->is_published, 
                                'bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300' => ! $post->is_published
                            ])>
                                {{ $post->is_published ? 'Publicado' : 'No publicado' }}
                            </span>
                        </th>
                        <td class="px-6 py-4 text-sm md:text-base">
                            {{ Str::limit($post->excerpt, 100, '...') }}
                        </td>
                        <td class="px-2 py-4 text-center" width="15">
                            <a href="{{ route('admin.posts.edit', $post) }}" class="font-medium text-blue-600 dark:text-blue-500"><i class="fa-solid fa-pen-to-square"></i></a>
                        </td>
                        <td class="pl-2 pr-6 py-4 text-center" width="15">
                            <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" id="formDelete-{{ $post->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="event.preventDefault(); deletepost({{ $post }})" class="font-medium text-red-600 dark:text-red-500"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <ul id="show_2" class="space-y-8 hidden">
        @foreach ($posts as $post)
            <li class="grid sm:grid-cols-3 sm:gap-4 pb-4 pt-2 sm-py-0 px-3 border border-gray-100 sm:border-2 rounded shadow-lg">
                <div class="sm:aspect-[16/9] object-cover object-center">
                    <a href="{{ route('admin.posts.edit', $post) }}">
                        <img src="{{ $post->image_path }}" alt="{{ $post->title }}"
                            class="rounded">
                    </a>
                </div>
                <div class="sm:col-span-2">
                    <a href="{{ route('admin.posts.edit', $post) }}">
                        <h2 class="text-base md:text-xl font-semibold mt-2 sm:mt-0 leading-4 sm:leading-none">{{ $post->title }}</h2>
                    </a>
                    
                    <hr class="my-1 sm:mt-2 sm:mb-2">

                    {{-- @class -> es una directiva de blade --}}
                    <span @class([
                        'bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300' => $post->is_published, 
                        'bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300' => ! $post->is_published
                    ])>
                        {{ $post->is_published ? 'Publicado' : 'Borrador' }}
                    </span>

                    <p class="text-gray-700 text-base md:text-lg mt-2 ">{{ $post->excerpt }}</p>

                    <div class="mt-3">
                        <a href="{{ route('admin.posts.edit', $post) }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm  dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 py-2 px-3">
                            Editar
                        </a>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>

    <div class="mt-8">
        {{ $posts->links() }}
    </div>

    @push('js')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            let estilo_main = true
            function cambiarEstilo(){
                if(estilo_main){
                    $('#show_2').removeClass('hidden')
                    $('#show_1').addClass('hidden')
                    estilo_main = false
                }else{
                    $('#show_2').addClass('hidden')
                    $('#show_1').removeClass('hidden')
                    estilo_main = true
                }
            }
        </script>
    @endpush

</x-admin-layout>