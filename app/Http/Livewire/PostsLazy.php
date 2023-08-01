<?php

namespace App\Http\Livewire;

use App\Models\Meme;
use Livewire\Component;

class PostsLazy extends Component
{

    public $perPage = 3;


    public function loadMore()
    {
        $this->perPage += 2;
        $this->emit('refresh');
    }

    public function render()
    {
        return view('livewire.posts-lazy', [
            'memes' => Meme::paginate($this->perPage)
        ]);
    }
}
