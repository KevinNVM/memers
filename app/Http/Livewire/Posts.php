<?php

namespace App\Http\Livewire;

use App\Models\Meme;
use Livewire\Component;

class Posts extends Component
{
    public $perPage = 2;

    function loadMore()
    {
        if ($this->perPage > Meme::count()) return false;

        $this->perPage += 2;
        $this->emit('refresh');

        return true;
    }

    public function render()
    {

        $memes = Meme::latest()->paginate($this->perPage);

        return view('livewire.posts', [
            'memes' => $memes
        ]);
    }
}
