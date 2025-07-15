@extends('layouts/main')

@section('content')

    @include('dashboard.fragment.errors-form')
    <div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-md">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Formulario para los post</h1>
    </div>
    
    <form action="{{ route('post.store')}}" method="post" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                    <input type="text" name="title" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div>
                <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                <input type="text" name="slug" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                <select name="category_id" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @foreach ($categories as $title => $id)
                        <option value="{{$id}}">{{$title}}</option>
                    @endforeach
                </select>       
            </div>

            <div>
                <label for="posted" class="block text-sm font-medium text-gray-700 mb-1">Posted</label>
                <select name="posted" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="not">Not</option>
                    <option value="yes">Yes</option>
                </select>
            </div>
        </div>
        
        <div class="space-y-4">
             <div>
                <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Content</label>
                <input type="text" name="content" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <input type="text" name="description" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Image</label>
                <input type="text" name="image" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>
        

        <div class="flex justify-end space-x-4">
            <button type="submit" class="px-4 py-2 bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150">Send</button>
        </div>

    </form>
@endsection

@section('morecontent')
<div class="max-w-2xl mx-auto mt-8 p-6 bg-white rounded-lg shadow-md">
    <h1 class="text-xl font-semibold text-gray-800 mb-4">Ver la lista de posts</h1>

    <a href="{{route('post.index')}}" class="text-blue-600 hover:text-blue-800 hover:underline">Lista post</a>
</div>


@endsection