@php
    $links = [
        [
            'name' => 'Dashboard',
            'url' => route('admin.dashboard'),
            'active' => request()->routeIs('admin.dashboard'),
            'icon' => 'fa-solid fa-gauge-high'
        ],
        [
            'name' => 'Categorias',
            'url' => route('admin.categories.index'),
            'active' => request()->routeIs('admin.categories.*'),
            'icon' => 'fa-solid fa-layer-group'
        ],
        [
            'name' => 'Posts',
            'url' => route('admin.posts.index'),
            'active' => request()->routeIs('admin.posts.*'),
            'icon' => 'fa-solid fa-signs-post'
        ],
        [
            'name' => 'Roles',
            'url' => route('admin.roles.index'),
            'active' => request()->routeIs('admin.roles.*'),
            'icon' => 'fa-solid fa-bars-staggered'
        ],
        [
            'name' => 'Permisos',
            'url' => route('admin.permissions.index'),
            'active' => request()->routeIs('admin.permissions.*'),
            'icon' => 'fa-solid fa-key'
        ],
    ]
@endphp
<aside id="logo-sidebar" 
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700" 
    :class="{
        '-translate-x-full': !open,
        'transform-none': open
    }"
    aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
        <ul class="space-y-2 font-medium">
            @foreach ($links as $link)
                <li>
                    <a href="{{ $link['url'] }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ $link['active'] ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                        <i class="{{ $link['icon'] }}"></i>
                        <span class="ms-3">{{ $link['name'] }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</aside>