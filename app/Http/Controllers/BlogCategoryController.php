<?php

namespace App\Http\Controllers;

use App\UseCases\BlogCategory\BlogCategoryUseCase;
use Illuminate\Http\Request;

class BlogCategoryController extends Controller
{
    protected $blogCategoryUseCase;

    public function __construct(BlogCategoryUseCase $blogCategoryUseCase)
    {
        $this->blogCategoryUseCase = $blogCategoryUseCase;
    }

    public function index()
    {
        $blogCategories = $this->blogCategoryUseCase->getAll();

        return [
            'code' => 200,
            'message' => 'Success',
            'data' => $blogCategories
        ];
    }

    public function show($id)
    {
        $blogCategory = $this->blogCategoryUseCase->find($id);

        return $blogCategory;
    }

    public function store(Request $request)
    {
        $data = $request->all();

        //... Validation here

        $blogCategory = $this->blogCategoryUseCase->create($data);

        return view('home.blogCategorys');
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        //... Validation here

        $blogCategory = $this->blogCategoryUseCase->update($id, $data);

        return view('home.blogCategorys');
    }

    public function destroy($id)
    {
        // $this->blogCategoryUseCase->delete($id);
        
        return view('home.blogCategorys');
    }
}
