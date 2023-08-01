<div>
    <div class="flex items-center gap-4 pt-2">
        <button wire:click="likePost" id="likePost{{ $meme->id }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor"
                class="w-9 h-9 transition active:scale-90 {{ in_array($meme->id, session('likedPosts', [])) ? 'fill-red-500 stroke-none' : 'active:fill-red-500 active:stroke-none' }}">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
            </svg>
        </button>
        <button @click="showModal =! showModal">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-9 h-9 transition active:scale-90">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
            </svg>
        </button>
    </div>
    <span class="text-sm font-bold">{{ $meme->likes }} Likes</span>
</div>
