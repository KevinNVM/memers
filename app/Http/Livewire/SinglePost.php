<?php

namespace App\Http\Livewire;

use App\Models\Meme;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SinglePost extends Component
{

    public Meme $meme;


    public function mount(Meme $meme)
    {
        $this->meme = $meme;
    }

    public function likePost()
    {

        $meme = $this->meme;
        $meme->likes++;
        $meme->save();

        // Emit an event after the post is liked
        $this->emit('postLiked', $meme->id);


        return $meme;
    }

    public function render()
    {
        return view('livewire.single-post', [
            'meme' => $this->meme
        ]);
    }
}
