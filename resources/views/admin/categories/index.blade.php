<x-admin-layout>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        ID
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Nombre
                    </th>
                    <th scope="col" colspan="3" class="px-6 py-3">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $category->id }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $category->name }}
                        </td>

                        <td class="px-2 py-4" width="15">
                            <a href="{{ route('admin.categories.show', $category) }}" class="font-medium text-gray-600 dark:text-gray-500"><i class="fa-regular fa-eye"></i></a>
                        </td>
                        <td class="px-2 py-4" width="15">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="font-medium text-blue-600 dark:text-blue-500"><i class="fa-solid fa-pen-to-square"></i></a>
                        </td>
                        <td class="pl-2 pr-6 py-4" width="15">
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="font-medium text-red-600 dark:text-red-500"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-2">
        {{ $categories->links() }}
    </div>

</x-admin-layout>