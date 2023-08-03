<div>
    @foreach ($memes as $meme)
        <livewire:post :meme="$meme" :key="'post-' . $meme->id" />
    @endforeach

    {{ $memes->hasMorePages() }}

    @if ($memes->hasMorePages())
        <div x-data x-intersect="$wire.loadMore().then(
        refreshSlide
    );">
        @else
            <h1 class="text-center font-semibold dark:text-white italic font-mono">
                No more content to show.
            </h1>
    @endif
</div>
</div>
