<x-admin-layout
    :breadcrumb="[
        [
            'name' => 'Dashboard',
            'url' => route('admin.dashboard')
        ],
        [
            'name' => 'Usuarios',
            'url' => route('admin.users.index')
        ],
        [
            'name' => $user->name
        ]
    ]">

    <div class="w-full max-w-lg mx-auto p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700">
        <form class="space-y-3" action="{{ route('admin.users.update', $user) }}" method="POST">

            @csrf
            @method('PUT')

            <h5 class="text-xl font-medium text-gray-900 dark:text-white">Editar Usuario</h5>
            
            <div>
                <label for="name" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
                <x-input type="text" class="block w-full p-1.5" placeholder="Nombre de usuario"
                    name="name" id="name" :value="old('name', $user->name)"/>
                <x-input-error for="name" class="flex justify-start" />
            </div>
            
            <div>
                <label for="email" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                <x-input type="text" class="block w-full p-1.5" placeholder="Email de usuario"
                    name="email" id="email" :value="old('email', $user->email)"/>
                <x-input-error for="email" class="flex justify-start" />
            </div>
            
            <div>
                <label for="password" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Contraseña</label>
                <x-input type="password" class="block w-full p-1.5" placeholder="********"
                    name="password" id="password"/>
                <x-input-error for="password" class="flex justify-start" />
            </div>

            <div>
                <label for="password_confirmation" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Confirmar Contraseña</label>
                <x-input type="password" class="block w-full p-1.5" placeholder="********"
                    name="password_confirmation" id="password_confirmation"/>
            </div>

            <div>
                <label for="role" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Rol</label>
                <ul>
                    @foreach ($roles as $role)
                        <li>
                            <x-label class="mb-1">
                                <x-checkbox
                                    name="roles[]" 
                                    value="{{ $role->id }}"
                                    :checked="in_array($role->id, old('roles', $user->roles->pluck('id')->toArray()))" />
                                <span class="align-middle">{{ $role->name }}</span>
                            </x-label>
                        </li>
                    @endforeach
                </ul>
            </div>

            
            <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Actualizar usuario
            </button>
        </form>
    </div>


</x-admin-layout>