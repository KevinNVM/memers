<?php

namespace App\Http\Controllers;

use App\Models\Meme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MemeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->only('update', 'create', 'store', 'destroy', 'index');
    }

    function welcome()
    {
        return view('welcome', [
            'memes' => Meme::latest()->paginate(2)
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('memes.index', [
            'memes' => Meme::where('user_id', Auth::user()->id)->latest()->paginate(5)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('memes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if (Auth::guest()) abort(403);

        $validated = $request->validate([
            'sources.*' => 'required|mimes:jpeg,png,jpg,gif,webp,webm,mp4,mkv|max:4096',
            'location' => 'nullable',
            'caption' => 'nullable'
        ]);

        $arrayOfImageNames = [];

        foreach ($request->file('sources') as $image) {

            $path = $image->store('public/images');

            array_push($arrayOfImageNames, $path);
        }

        $validated['sources'] = json_encode($arrayOfImageNames);
        $validated['user_id'] = Auth::user()->id;

        $meme = Meme::create($validated);

        return redirect()->route('memes.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Meme $meme)
    {
        return view('memes.show', compact('meme'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Meme $meme)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Meme $meme)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Meme $meme)
    {
        if ($meme->user_id !== Auth::user()?->id) abort(403);

        foreach (json_decode($meme->sources) as $key => $value) {
            Storage::delete($value);
        }
        $meme->delete();

        return redirect()->back();
    }

    function popular()
    {
        return view('memes.popular', [
            'memes' => Meme::orderBy('likes', 'desc')->paginate(5)

        ]);
    }
}
