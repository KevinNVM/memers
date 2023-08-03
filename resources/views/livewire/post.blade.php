<div class="meme-card dark:text-white mb-10">
    <div class="flex items-center justify-between px-2 py-2">
        <div class="flex items-center gap-4">
            <img class="object-cover w-8 h-8 rounded-full ring ring-gray-300 dark:ring-gray-600"
                src="{{ url(str_replace('public', 'storage', $meme->user->image)) }}" />
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


                    @if ($meme->user_id === Auth::user()?->id)
                        <form method="POST" action="{{ route('memes.destroy', $meme->id) }}">
                            @csrf
                            @method('delete')
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
                    @else
                        <form action="#">
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
                    @endif
                </div>
            </div>
        </div>
    </div>

    @php($sources = json_decode($meme->sources))
    <section class="splide" aria-label="Splide Basic HTML Example">
        <div class="splide__track">
            <ul class="splide__list">
                @foreach ($sources as $src)
                    <li class="splide__slide flex justify-center items-center lg:rounded-lg overflow-hidden" x-data
                        @dblclick="document.querySelector('#likePost{{ $meme->id }}').click()">
                        @php($ext = explode('.', $src)[1])
                        @php($src = str_replace('public/', 'storage/', $src))
                        @if (in_array($ext, ['mp4', 'webm', 'mkv']))
                            <video src="{{ url($src) }}" controls loop x-data
                                x-intersect.full="$store.player.play($el)" x-intersect.full:leave="$el.pause()"
                                loading="lazy" autoplay muted @click="$el.muted = false;"></video>
                        @else
                            <object data="{{ url($src) }}" class="w-full object-cover " loading="lazy">
                                <img src="/404.jpg" loading="lazy">
                            </object>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </section>



    <div class="dark:text-white px-2">

        <livewire:like-post :meme="$meme" />


        @if ($meme->caption)
            <p x-data="{ showMore: false }"
                :class="{ 'line-clamp-2 cursor-pointer': !showMore, 'line-clamp-none cursor-default': showMore }"
                @click="showMore =! showMore" class="line-clamp-2 select-none">
                <span class="font-bold">{{ str($meme->user->username)->words(1) }} </span>
                {{ $meme->caption }}
            </p>
        @endif
        <p class="text-xs text-gray-500">{{ $meme->created_at->diffForHumans() }}</p>
    </div>

    <script>
        // Get all video elements
        var vids = document.querySelectorAll('video');

        // Loop through all video elements and set controls as false
        vids.forEach(vid => {

            // Add event listener for click event
            vid.addEventListener('click', function() {
                // Toggle video play/pause
                if (this.paused) {

                    console.log('play')

                    this.play();
                } else {
                    console.log('pause  ')
                    this.pause();
                }
            });
        });
    </script>

</div>
