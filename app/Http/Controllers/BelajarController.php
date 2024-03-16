<?php

namespace App\Http\Controllers;

use App\Models\Belajar;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BelajarController extends Controller
{
   /**
     * index
     *
     * @return View
     */
    public function index(): View
    {
        //get posts
        $belajars = Belajar::latest()->paginate(5);

        //render view with posts
        return view('belajar.index', compact('belajars'));
    }

 /**
     * create
     *
     * @return View
     */
    public function create(): View
    {
        return view('belajar.index');
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
        $image->storeAs('public/belajar', $image->hashName());

        //create post
        Belajar::create([
            'image'     => $image->hashName(),
            'title'     => $request->title,
            'content'   => $request->content
        ]);

        //redirect to index
        return redirect()->route('belajars.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }
}