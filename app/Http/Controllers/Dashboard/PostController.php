<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\Post\StoreRequest;

class PostController extends Controller
{
    public function index()
    {
        /*
        $post = Post::where('title','test title')->get()->first(); 
        dd($post);

        return 'Index';
        
        return response()->json([
            'name' => 'Abigail',
            'state' => 'CA',
        ]);

        
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

        //dd($post);
        
        $post = Post::where('title','test title')->get()->first(); 

        $post->update(
            [
                'slug' => 'update slug',
            ]
        );
        */

        $postList = Post::paginate(2);

        return view('dashboard/post/list',compact('postList'));

    }

    public function create()
    {
        $categories = Category::pluck('id','title');
        
        return view('dashboard/post/create',compact('categories'));
    }

    public function store(StoreRequest $request)
    {

        Post::create($request->all());

        /*
        Post::create([
            'title' => $request->all()['title'],
            'slug' => $request->all()['slug'],
            'content' => $request->all()['content'],
            'category_id' => $request->all()['category_id'],
            'description' => $request->all()['description'],
            'posted' => $request->all()['posted'],
            'image' => $request->all()['image'],
        ]);
        */

        return redirect()->route('post.create');
    }

    public function show(string $id)
    {

    }

    public function edit(string $id)
    {
        $post = Post::find($id); 
        $categories = Category::pluck('id','title');

        return view('dashboard/post/edit',compact('post','categories'));
    }

    public function update(Request $request, string $id)
    {
        $post = Post::find($id);
        $post->update($request->all());
        return to_route('post.index');

    }

    public function destroy(string $id)
    {
        
    }
}
