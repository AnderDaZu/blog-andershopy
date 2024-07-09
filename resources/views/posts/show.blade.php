<x-app-layout>

    <section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="mb-2">
            @foreach ($post->tags as $tag)
                <span
                    class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">
                    {{ $tag->name }}
                </span>
            @endforeach
        </div>

        <h2 class="text-lg md:text-xl lg:text-2xl font-semibold uppercase">{{ $post->title }}</h2>

        <hr class="my-2">

        <p class="text-sm mb-6">{{ $post->published_at->format('d M Y') }} - <span class="uppercase bg-blue-400 py-1 p-1">{{ $post->user->name }}</span></p>

        <figure class="mb-6">
            <img src="{{ $post->image }}" alt="{{ $post->title }}" class="w-full aspect-[16/9] object-cover object-center shadow-lg rounded-lg">
        </figure>

        <div>
            {!! $post->body !!}
        </div>
    </section>

</x-app-layout>