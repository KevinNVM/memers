<x-app-layout>

    <x-navbar />


    <div class="max-w-screen-sm mx-auto my-8">

        <h2 class="text-lg font-semibold dark:text-white text-center">
            Your Memes
        </h2>

        @forelse ($memes as $meme)
            <livewire:post :meme="$meme" />
        @empty
            <h1 class="text-gray-500 italic text-center">There are no memes yet :(</h1>
        @endforelse

        <div class="py-6">{{ $memes->links() }}</div>


    </div>

</x-app-layout>
