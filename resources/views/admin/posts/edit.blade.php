<x-admin-layout>

    @push('css')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endpush

    <h1 class="text-base sm:text-xl md:text-2xl font-semibold uppercase">Editar Artículo</h1>
    
    <hr class="my-2">

    <form action="{{ route('admin.posts.update', $post) }}" 
        enctype="multipart/form-data" {{-- Esta propiedad habilita la subida de archivos --}}
        method="post">
        @csrf
        @method('PUT')

        <div class="my-4 mx-auto">
            <figure class="w-full relative">
                <img class="aspect-[16/9] object-cover object-center max-w-md rounded-lg border-gray-400 border-dashed border-2 border-opacity-60" 
                    src="{{$post->image}}" 
                    id="imgPreview"
                    alt="image description">
                
                <div class="absolute left-4 top-4">
                    <label class="cursor-pointer bg-slate-200 text-gray-700 py-2 px-4 rounded-md shadow-md">
                        <i class="fa-solid fa-camera mr-2"></i> Actualizar Imagen

                        <input type="file" 
                            accept="image/*" 
                            name="image" 
                            onchange="previewImage(event, '#imgPreview')"
                            class="hidden">
                    </label>
                </div>
            </figure>
        </div>

        <div class="my-4 grid sm:grid-cols-5 md:grid-cols-6 items-center">
            <x-label class="sm:col-span-2 mr-2 taxt-base md:text-lg uppercase">
                Título
            </x-label>

            <x-input class="block mt-1 w-full sm:col-span-3 md:col-span-4" type="text" name="title" value="{{ old('title', $post->title) }}" placeholder="Ingrese título del artículo" />

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
                Etiquetas
            </x-label>
            <select class="tag-multiple w-full sm:col-span-3 md:col-span-4" name="tags[]" multiple="multiple">
                @foreach (old('tags', $post->tags ) as $item)
                    @if ( collect(old('tags') ?? [])->isNotEmpty() )
                        <option value="{{ $item }}" selected>{{ $item }}</option>
                    @else
                        <option value="{{ $item->name }}" selected>{{ $item->name }}</option>
                    @endif
                @endforeach
            </select>
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
            <x-danger-button onclick="deletePost()">Eliminar artículo</x-danger-button>
            <x-button class="ml-2">Actualizar Artículo</x-button>
        </div>
    </form>

    <form action="{{ route('admin.posts.destroy', $post) }}" method="post" id="formDelete">
        @csrf
        @method('DELETE')
    </form>

    @push('js')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        {{-- Select2 le ofrece un cuadro de selección personalizable compatible con búsqueda, etiquetado,   --}}
        {{-- conjuntos de datos remotos, desplazamiento infinito y muchas otras opciones muy utilizadas. --}}
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            function deletePost(){
                Swal.fire({
                    title: '¿Deseas borrar este artículo?',
                    text: "No podras revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, borrar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('formDelete').submit();
                    }    
                })
            }

            function previewImage( event, id ){

                // Recuperamos el input que desencadeno la acción
                const input = event.target;

                // Recuperamos la etiqueta img donde cargaremos la imagen
                $imgPreview = document.querySelector(id);

                // Validamos si existe una imagen seleccionada
                if ( !input.files.length ) return

                // Recuperamos el archivo subido
                file = input.files[0]

                // Creamos la url
                objectURL = URL.createObjectURL(file)

                // Modificamos el atributo src de la etiqueta img
                $imgPreview.src = objectURL
            }

            $(document).ready(function() {
                $('.tag-multiple').select2({
                    tags: true, // permite agregar valores que no están en la db
                    tokenSeparators: [',', ' '], // cuando se va a agregar una etiqueta, esta propiedad permite agregarla luego de escribirla y de habar dado ',' o ' '
                    ajax: {
                        url: "{{ route('api.tags.index') }}",
                        dataType: 'json',
                        delay: 250,
                        data: params => {
                            return {
                                term: params.term
                            }
                        },
                        processResults: data => {
                            return {
                                results: data
                            }
                        }
                    }
                });
            });
        </script>
    @endpush

</x-admin-layout>