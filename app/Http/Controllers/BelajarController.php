<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BelajarController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index(): View
    {
        //get posts
        $belajars = Belajar::latest()->paginate(5);

        //render view with posts
        return view('belajars.index', compact('belajars'));
    }

    /**
     * create
     *
     * @return void
     */
    public function create(): View
    {
        return view('belajar.create');
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        //validate form
        $this->validate($request, [
            'image'     => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'title'     => 'required|min:5',
            'content'   => 'required|min:10'
        ]);

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/belajars', $image->hashName());

        //create post
        Belajar::create([
            'image'     => $image->hashName(),
            'title'     => $request->title,
            'content'   => $request->content
        ]);

        //redirect to index
        return redirect()->route('belajars.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    /**
     * show
     *
     * @param  mixed $id
     * @return View
     */
    public function show(string $id): View
    {
        //get post by ID
        $belajar = Belajar::findOrFail($id);

        //render view with post
        return view('belajars.show', compact('belajar'));
    }
    /**
     * edit
     *
     * @param  mixed $id
     * @return View
     */
    public function edit(string $id): View
    {
        //get post by ID
        $belajar = Belajar::findOrFail($id);

        //render view with post
        return view('belajars.edit', compact('belajar'));
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //validate form
        $this->validate($request, [
            'image'     => 'image|mimes:jpeg,jpg,png|max:2048',
            'title'     => 'required|min:5',
            'content'   => 'required|min:10'
        ]);

        //get post by ID
        $belajar = Belajar::findOrFail($id);

        //check if image is uploaded
        if ($request->hasFile('image')) {

            //upload new image
            $image = $request->file('image');
            $image->storeAs('public/belajars', $image->hashName());

            //delete old image
            Storage::delete('public/posts/' . $belajar->image);

            //update post with new image
            $belajar->update([
                'image'     => $image->hashName(),
                'title'     => $request->title,
                'content'   => $request->content
            ]);
        } else {

            //update post without image
            $belajar->update([
                'title'     => $request->title,
                'content'   => $request->content
            ]);
        }

        //redirect to index
        return redirect()->route('belajars.index')->with(['success' => 'Data Berhasil Diubah!']);
    }
}
