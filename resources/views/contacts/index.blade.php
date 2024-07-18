<x-app-layout>
    
    <section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-gray-50 p-8 rounded-lg shadow-lg">
            <form action="{{ route('contacts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <x-validation-errors class="mb-4" />

                <div class="mb-4">
                    <x-label>Nombre</x-label>
                    <x-input name="name" type="text" class="w-full" placeholder="Ingrese nombre del contacto" :value="old('name')" />
                </div>

                <div class="mb-4">
                    <x-label>Correo</x-label>
                    <x-input name="email" type="email" class="w-full" placeholder="Ingrese email del contacto" :value="old('email')" />
                </div>

                <div class="mb-4">
                    <x-label>Mensaje</x-label>
                    <textarea class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="message" cols="30" rows="4" placeholder="Ingrese mensaje">{{ old('message') }}</textarea>
                </div>

                <div class="mb-4">
                    <x-label>Archivo</x-label>
                    <x-input type="file" name="file" />
                </div>

                <x-button>Enviar</x-button>
            </form>
        </div>
    </section>

</x-app-layout>