<?php

namespace App\Http\Controllers\Api;

use App\Models\Belajar;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

//import Resource "PostResource"
use App\Http\Resources\BelajarResource;

class BelajarController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get all posts
        $belajars = Belajar::latest()->paginate(5);

        return new BelajarResource(true, 'List Data belajar', $belajars);
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'image'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title'     => 'required',
            'content'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/belajars', $image->hashName());

        //create post
        $belajar = Belajar::create([
            'image'     => $image->hashName(),
            'title'     => $request->title,
            'content'   => $request->content,
        ]);

        //return response
        return new BelajarResource(true, 'Data Belajar Berhasil Ditambahkan!', $belajar);
    }
}

