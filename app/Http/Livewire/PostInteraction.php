<?php

namespace App\Http\Livewire;

use App\Models\Meme;
use Livewire\Component;

class PostInteraction extends Component
{

    public $meme;

    public function mount($memeId)
    {
        $this->meme = Meme::find($memeId);
    }


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
        return view('livewire.post-interaction', [
            'likes' => $this->meme->likes
        ]);
    }
}
