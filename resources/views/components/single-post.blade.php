<section class="meme-card dark:text-white mb-10">
    <div class="flex items-center justify-between px-2 py-2">
        <div class="flex items-center gap-4">
            <img class="object-cover w-8 h-8 rounded-full ring ring-gray-300 dark:ring-gray-600"
                src="https://images.unsplash.com/photo-1570295999919-56ceb5ecca61?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=facearea&facepad=4&w=880&h=880&q=100" />
            <div class="flex flex-col">
                <p class="dark:text-white">
                    <a href="/">{{ $meme->user->username }}</a>
                </p>
                <span class="text-xs dark:text-gray-500">{{ $meme->location }}</span>
            </div>
        </div>

        <div x-data="{ isActive: false }" class="relative">
            <button @click="isActive =! isActive">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
                </svg>
            </button>

            <div class="absolute end-0 z-10 mt-2 w-56 rounded-md border border-gray-100 bg-white shadow-lg dark:border-gray-800 dark:bg-gray-900"
                role="menu" x-cloak x-transition x-show="isActive" x-on:click.away="isActive = false"
                x-on:keydown.escape.window="isActive = false">
                <div class="p-2">

                    <a href="#"
                        class="block rounded-lg px-4 py-2 text-sm text-gray-500 hover:bg-gray-50 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-gray-300"
                        role="menuitem">
                        Unpublish Product
                    </a>

                    <form method="POST" action="#">
                        <button type="submit"
                            class="flex w-full items-center gap-2 rounded-lg px-4 py-2 text-sm text-red-700 hover:bg-red-50 dark:text-red-500 dark:hover:bg-red-600/10"
                            role="menuitem">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                            </svg>

                            Report
                        </button>
                    </form>
                    <form method="POST" action="#">
                        <button type="submit"
                            class="flex w-full items-center gap-2 rounded-lg px-4 py-2 text-sm text-red-700 hover:bg-red-50 dark:text-red-500 dark:hover:bg-red-600/10"
                            role="menuitem">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                            </svg>



                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <section class="splide" aria-label="Splide Basic HTML Example">
        <div class="splide__track">
            <ul class="splide__list">
                @php($sources = json_decode($meme->sources))
                @foreach ($sources as $src)
                    <li class="splide__slide flex items-center justify-center lg:rounded-lg overflow-hidden">
                        <object data="{{ str_replace('public/', '', asset('storage/' . $src)) }}"
                            class="w-full object-cover " loading="lazy">
                            <img src="/404.jpg" loading="lazy">
                        </object>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    <div class="dark:text-white px-2">

        {{-- <livewire:post-interaction :memeId="$meme->id" /> --}}

        {{-- @livewire('p-post-interaction', ['meme' => $meme]) --}}

        <div>
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
        </div>


        @if ($meme->caption)
            <p x-data="{ showMore: false }"
                :class="{ 'line-clamp-2 cursor-pointer': !showMore, 'line-clamp-none cursor-default': showMore }"
                @click="showMore =! showMore" class="line-clamp-2 select-none">
                <span class="font-bold">{{ str($meme->user->username)->words(1) }} </span>
                {{ $meme->caption }}
            </p>
        @endif
        <p class="text-xs text-gray-500">5 Min Ago</p>
    </div>

</section>
