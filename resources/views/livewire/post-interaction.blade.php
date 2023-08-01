{{-- <div>
    <div x-data="{ showModal: false }" x-on:keydown.window.escape="showModal = false">
        <div class="flex items-center gap-4 pt-2">
            <button wire:click="likePost">
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


        <div>
            <div x-cloak x-show="showModal" x-transition.opacity class="fixed inset-0 z-10 bg-secondary-700/50"></div>
            <div x-cloak x-show="showModal" x-transition
                class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-0">
                <div
                    class="mx-auto overflow-hidden rounded-lg bg-white dark:bg-gray-800 shadow-xl sm:w-full sm:max-w-xl">
                    <div class="relative p-6 flex items-center flex-wrap gap-6">
                        <button data-sharer="facebook" data-title="Look at this post!!" data-url="{{ url('') }}"
                            type="button" class="flex flex-col items-center">
                            <i class="bi bi-facebook text-4xl"></i>
                            Facebook
                        </button>
                        <button data-sharer="twitter" data-title="Look at this post!!" data-url="{{ url('') }}"
                            type="button" class="flex flex-col items-center">
                            <i class="bi bi-twitter text-4xl"></i>
                            Twitter
                        </button>
                        <button data-sharer="linkedin" data-title="Look at this post!!" data-url="{{ url('') }}"
                            type="button" class="flex flex-col items-center">
                            <i class="bi bi-linkedin text-4xl"></i>
                            LinkedIn
                        </button>
                        <button data-sharer="email" data-title="Look at this post!!" data-url="{{ url('') }}"
                            type="button" class="flex flex-col items-center">
                            <i class="bi bi-envelope text-4xl"></i>
                            Email
                        </button>
                        <button data-sharer="whatsapp" data-title="Look at this post!!" data-url="{{ url('') }}"
                            type="button" class="flex flex-col items-center">
                            <i class="bi bi-whatsapp text-4xl"></i>
                            Whatsapp
                        </button>
                        <button data-sharer="telegram" data-title="Look at this post!!" data-url="{{ url('') }}"
                            type="button" class="flex flex-col items-center">
                            <i class="bi bi-telegram text-4xl"></i>
                            Telegram
                        </button>
                        <button data-sharer="pinterest" data-title="Look at this post!!" data-url="{{ url('') }}"
                            type="button" class="flex flex-col items-center">
                            <i class="bi bi-pinterest text-4xl"></i>
                            Pinterest
                        </button>
                        <button data-sharer="reddit" data-title="Look at this post!!" data-url="{{ url('') }}"
                            type="button" class="flex flex-col items-center">
                            <i class="bi bi-reddit text-4xl"></i>
                            Reddit
                        </button>
                    </div>
                    <div class="flex justify-end gap-3 bg-secondary-50 px-6 py-3">
                        <button type="button" x-on:click="showModal = false"
                            class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-center text-sm font-medium text-gray-700 shadow-sm transition-all hover:bg-gray-100 focus:ring focus:ring-gray-100 disabled:cursor-not-allowed disabled:border-gray-100 disabled:bg-gray-50 disabled:text-gray-400">Cancel</button>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div> --}}
