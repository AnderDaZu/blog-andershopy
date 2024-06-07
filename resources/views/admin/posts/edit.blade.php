<x-admin-layout>

    <h1 class="text-base sm:text-xl md:text-2xl font-semibold uppercase">Editar Artículo</h1>
    
    <hr class="my-2">

    <form action="{{ route('admin.posts.update', $post) }}" method="post">
        @csrf
        @method('PUT')

        <div class="my-4 grid sm:grid-cols-5 md:grid-cols-6 items-center">
            <x-label class="sm:col-span-2 mr-2 taxt-base md:text-lg uppercase">
                Título
            </x-label>

            <x-input class="block mt-1 w-full sm:col-span-3 md:col-span-4" type="text" name="title" value="{{ old('title', $post->title) }}" placeholder="Ingrese título del artículo"  autofocus />

        </div>
        <div class="flex sm:justify-end">
            <x-input-error for="title" class="-mt-2" />
        </div>

        <div class="my-4 grid sm:grid-cols-5 md:grid-cols-6 items-center">
            <x-label class="sm:col-span-2 mr-2 taxt-base md:text-lg uppercase">
                Slug
            </x-label>

            <x-input class="block mt-1 w-full sm:col-span-3 md:col-span-4" type="text" name="slug" 
                :value="old('slug', $post->slug)" 
                placeholder="Ingrese slug"
                :disabled="true"/>
        </div>
        <div class="flex sm:justify-end">
            <x-input-error for="slug" class="-mt-2" />
        </div>

        <div class="my-4 grid sm:grid-cols-5 md:grid-cols-6 items-center">
            <x-label class="sm:col-span-2 mr-2 taxt-base md:text-lg uppercase">
                Categoría
            </x-label>

            <x-cstm-select class="w-full sm:col-span-3 md:col-span-4" name="category_id">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected( $category->id == old('category_id', $post->category_id) )>{{ $category->name }}</option>
                @endforeach
            </x-cstm-select>
        </div>
        <div class="flex sm:justify-end">
            <x-input-error for="category_id" class="-mt-2" />
        </div>

        <div class="my-4 grid sm:grid-cols-5 md:grid-cols-6 items-center">
            <x-label class="sm:col-span-2 mr-2 taxt-base md:text-lg uppercase">
                Resumen
            </x-label>
            <x-cstm-textarea class="w-full sm:col-span-3 md:col-span-4" name="excerpt">
                {{ old('excerpt', $post->excerpt) }}
            </x-cstm-textarea>
        </div>
        <div class="flex sm:justify-end">
            <x-input-error for="excerpt" class="-mt-2" />
        </div>
        
        <div class="my-4 grid sm:grid-cols-5 md:grid-cols-6 items-center">
            <x-label class="sm:col-span-2 mr-2 taxt-base md:text-lg uppercase">
                Cuerpo
            </x-label>
            <x-cstm-textarea class="w-full sm:col-span-3 md:col-span-4" name="body">
                {{ old('body', $post->body) }}
            </x-cstm-textarea>
        </div>
        <div class="flex sm:justify-end">
            <x-input-error for="body" class="-mt-2" />
        </div>

        <div class="mt-4 mb-6 flex justify-end">
            <input type="hidden" name="is_published" value="0">
            <label class="inline-flex items-center cursor-pointer">
                <input name="is_published" 
                    type="checkbox" 
                    value="1" 
                    class="sr-only peer"
                    @checked( old('is_published', $post->is_published) )>
                <div class="relative w-11 h-6 bg-gray-300 rounded-full peer peer-focus:ring-4 peer-focus:ring-indigo-300 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                <span class="ms-3 text-sm font-medium text-gray-900">Publicar</span>
            </label>
        </div>

        <div class="flex sm:justify-end mt-4">
            <x-button>Actualizar Artículo</x-button>
        </div>
    </form>

</x-admin-layout>