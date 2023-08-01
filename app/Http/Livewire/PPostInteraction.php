<?php

namespace App\Http\Livewire;

use Livewire\Component;

class PPostInteraction extends Component
{

    public $meme;

    public function likePost()
    {
        $meme = $this->meme;

        if (in_array($meme->id, session('likedPosts', []))) {
            $meme->likes--;
            if ($meme->save()) session()->pull('likedPosts', $meme->id);
        } else {
            $meme->likes++;
            if ($meme->save()) session()->push('likedPosts', $meme->id);
        }
    }

    public function render()
    {
        return view('livewire.p-post-interaction');
    }
}
