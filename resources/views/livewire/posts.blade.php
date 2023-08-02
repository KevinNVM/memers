<div>
    @forelse ($memes as $meme)
        <livewire:post :meme="$meme" :key="'post-' . $meme->id" />
    @empty
        <p class="text-gray-500 text-center">No post to show</p>
    @endforelse

    @if ($memes->hasMorePages())
        <div x-data
            x-intersect="$wire.loadMore().then(
        () => {
            window.addEventListener('DOMContentLoaded', window.refreshSlide)
        }
    )">
    @endif
</div>
</div>
