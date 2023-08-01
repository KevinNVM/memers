<?php

namespace App\Http\Controllers;

use App\Models\Meme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except('show');
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
            'memes' => Meme::where('user_id', Auth::user()->id)->paginate(10)
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
            'sources.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp,mp4,mkv|max:4096',
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

        $meme->delete();

        return redirect()->back();
    }
}
