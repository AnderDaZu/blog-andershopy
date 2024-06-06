<x-admin-layout>
    
    <h1 class="text-lg sm:text-xl md:text-2xl font-semibold uppercase">Crear nuevo artículo</h1>

    <form action="{{ route('admin.posts.store') }}" method="post" class="mt-6">
        @csrf

        <div class="my-4 grid sm:grid-cols-5 md:grid-cols-6 items-center">
            <x-label class="sm:col-span-2 mr-2 taxt-base md:text-lg uppercase">
                Título
            </x-label>

            <x-input class="block mt-1 w-full sm:col-span-3 md:col-span-4" type="text" name="title" :value="old('title')" placeholder="Ingrese título del artículo"  autofocus />

        </div>
        <div class="flex sm:justify-end">
            <x-input-error for="title" class="-mt-2" />
        </div>

        <div class="my-4 grid sm:grid-cols-5 md:grid-cols-6 items-center">
            <x-label class="sm:col-span-2 mr-2 taxt-base md:text-lg uppercase">
                Slug
            </x-label>

            <x-input class="block mt-1 w-full sm:col-span-3 md:col-span-4" type="text" name="slug" :value="old('slug')" placeholder="Ingrese slug" />
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
                    <option value="{{ $category->id }}" @selected( $category->id == old('category_id') )>{{ $category->name }}</option>
                @endforeach
            </x-cstm-select>
        </div>
        <div class="flex sm:justify-end">
            <x-input-error for="category_id" class="-mt-2" />
        </div>

        <div class="flex sm:justify-end mt-4">
            <x-button>crear Artículo</x-button>
        </div>
    </form>

</x-admin-layout>