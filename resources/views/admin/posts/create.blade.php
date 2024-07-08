<x-admin-layout
    :breadcrumb="[
        [
            'name' => 'Dashboard',
            'url' => route('admin.dashboard')
        ],
        [
            'name' => 'Artículos',
            'url' => route('admin.posts.index')
        ],
        [
            'name' => 'Crear Artículo'
        ]
    ]">
    
    <h1 class="text-lg sm:text-xl md:text-2xl font-semibold uppercase">Crear nuevo artículo</h1>

    <form action="{{ route('admin.posts.store') }}" 
        method="post" 
        class="mt-6"
        {{-- x-data="" -> permite iniciar alpine --}}
        x-data="data()"
        {{-- x-init="$watch()" -> se mantiene a la escucha del elemento que le definamos --}}
        {{-- luego le indicamos que el valor de title se guarde en value y a su vez que ejecute la función string_to_slug --}}
        x-init="$watch('title', value => { string_to_slug(value) } )">
        @csrf

        <div class="my-4 grid sm:grid-cols-5 md:grid-cols-6 items-center">
            <x-label class="sm:col-span-2 mr-2 taxt-base md:text-lg uppercase">
                Título
            </x-label>

            <x-input x-model="title" class="block mt-1 w-full sm:col-span-3 md:col-span-4" type="text" name="title" :value="old('title')" placeholder="Ingrese título del artículo"  autofocus />

        </div>
        <div class="flex sm:justify-end">
            <x-input-error for="title" class="-mt-2" />
        </div>

        <div class="my-4 grid sm:grid-cols-5 md:grid-cols-6 items-center">
            <x-label class="sm:col-span-2 mr-2 taxt-base md:text-lg uppercase" value="{{ old('slug') }}">
                Slug
            </x-label>

            <x-input x-model="slug" class="block mt-1 w-full sm:col-span-3 md:col-span-4" type="text" name="slug" :value="old('slug')" placeholder="Ingrese slug" />
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

    @push('js')
        <script>
            function data(){
                return {
                    title: '',
                    slug: '',

                    string_to_slug(str){
                        str = str.replace(/^\s+|\s+$/g, '');
                        str = str.toLowerCase();
                        var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
                        var to = "aaaaeeeeiiiioooouuuunc------";
                        for (var i = 0, l = from.length; i < l; i++) {
                            str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
                        }
                        str = str.replace(/[^a-z0-9 -]/g, '')
                            .replace(/\s+/g, '-')
                            .replace(/-+/g, '-');
                        this.slug = str;
                    }
                }
            }
        </script>
    @endpush

</x-admin-layout>