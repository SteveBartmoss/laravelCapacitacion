<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        /*
        $post = Post::updateOrCreate([
            'title' => 'test title',
        ],
        [
            'slug' => 'test slug',
            'content' => 'test content',
            'category_id' => 1,
            'description' => 'test description',
            'posted' => 'not',
            'image' => 'test image',
        ]);
        */

        //dd($post);
        
        $post = Post::where('title','test title')->get()->first(); 

        $post->update(
            [
                'slug' => 'update slug',
            ]
        );
        
        return 'Index';
    }

    public function create()
    {

    }

    public function store(Request $request)
    {

    }

    public function show(string $id)
    {

    }

    public function edit(string $id)
    {

    }

    public function update(Request $request, string $id)
    {

    }

    public function destroy(string $id)
    {
        
    }
}
