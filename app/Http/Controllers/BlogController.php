<?php

namespace App\Http\Controllers;

use App\UseCases\Blog\BlogUseCase;
use Illuminate\Http\Request;
use App\Http\Resources\Blog as BlogResource;

class BlogController extends Controller
{
    protected $blogUseCase;

    public function __construct(BlogUseCase $blogUseCase)
    {
        $this->blogUseCase = $blogUseCase;
    }

    public function index(Request $request)
    {
        $query = $request->query();
        
        $blogs = $this->blogUseCase->getAllByCondition($query);

        return [
            'code' => 200,
            'message' => 'Success',
            'data' => $blogs
        ];
    }

    public function blogsByCategoryId($id, Request $request)
    {
        $query = $request->query();

        $blogs = $this->blogUseCase->getBlogsByCategoryId($id, $query);

        return [
            'code' => 200,
            'message' => 'Success',
            'data' => $blogs
        ];
    }

    public function show($id)
    {
        $blog = $this->blogUseCase->find($id);

        return [
            'code' => 200,
            'message' => 'Success',
            'data' => $blog ? new BlogResource($blog) : null
        ];
    }

    public function store(Request $request)
    {
        $data = $request->all();

        //... Validation here

        $blog = $this->blogUseCase->create($data);

        return view('home.blogs');
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        //... Validation here

        $blog = $this->blogUseCase->update($id, $data);

        return view('home.blogs');
    }

    public function destroy($id)
    {
        // $this->blogUseCase->delete($id);
        
        return view('home.blogs');
    }
}
