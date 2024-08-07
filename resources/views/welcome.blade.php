<x-app-layout>
    <figure class="mb-6">
        <img src="{{ asset('img/home/portada_blog.png') }}" alt="portada"
            class="w-full aspect-[3/1] object-cover object-center">
    </figure>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-8">
        <h2 class="text-lg sm:text-xl md:text-2xl lg:text-3xl text-center font-semibold uppercase mb-6">
            Lista de artículos
        </h2>

        <div class="grid grid-cols-4">

            <div class="col-span-1">
                <form action="{{ route('home') }}">
                    <div class="mb-4">
                        <p class="text-base md:text-lg font-semibold mb-1">Ordenar:</p>
    
                        <select name="order" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="new" @selected( request('order') == 'new' )>Más nuevos</option>
                            <option value="old" @selected( request('order') == 'old' )>Más antiguos</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <p class="text-base md:text-lg font-semibold mb-1">Categorías:</p>
        
                        @foreach ($categories as $category)
                            <label class="inline-flex items-center mt-1">
                                <x-input type="checkbox" class="" name="categories[]" value="{{ $category->id }}" 
                                    :checked="is_array(request('categories')) && in_array($category->id, request('categories'))"/>
                                    {{-- :checked="in_array( $category->id, request('categories') ?? [])"/> --}}
                                {{-- <input type="checkbox" name="categories[]" value="{{ $category->id }}"> --}}
                                <span class="ml-2 text-gray-700">{{ $category->name }}</span>
                            </label>
                        @endforeach
                    </div>

                    <x-button>Aplicar filtros</x-button>
                </form>
            </div>

            <div class="col-span-3">
                <div class="space-y-6">
                    @foreach ($posts as $post)
                        <article class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-50 shadow-md p-6 rounded-lg">
                            <figure>
                                <a href="{{ route('posts.show', $post) }}">
                                    <img src="{{ $post->image }}" alt="{{ $post->title }}"
                                        class="rounded-lg">
                                </a>
                            </figure>
                            <div>
                                <h3 class="text-base md:text-lg lg:text-xl font-semibold uppercase">{{ $post->title }}</h3>
        
                                <hr class="my-2">
        
                                <div class="mb-1">
                                    @foreach ($post->tags as $tag)
                                        <a href="{{ route('home') . '/?tag=' . $tag->name }}" class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">
                                            {{ $tag->name }}
                                        </a>
                                    @endforeach
                                </div>
        
                                <p class="text-sm mb-1">
                                    {{-- para aplicar format -> en el módelo se debe aplicar el casteo de la propiedad published_at --}}
                                    {{ $post->published_at->format('d M Y') }}
                                </p>
        
                                <div class="mb-2">
                                    {{ Str::limit($post->excerpt, 100, '...') }}
                                </div>
        
                                <div>
                                    <a href="{{ route('posts.show', $post) }}"
                                        class="bg-blue-500 hover:bg-blue-700 text-xs text-gray-50 font-semibold py-2 px-4 rounded">
                                        Leer más...
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
        
                    <div class="mt-4">
                        {{ $posts->links() }}
                    </div>
                </div>
            </div>

        </div>

    </section>
</x-app-layout>