<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UseCases\Category\CategoryUseCase;

class CategoryController extends Controller
{
    protected $categoryUseCase;

    public function __construct(CategoryUseCase $categoryUseCase)
    {
        $this->categoryUseCase = $categoryUseCase;
    }

    public function index()
    {
        $categories = $this->categoryUseCase->getAll();
        
        return [
            'code' => 200,
            'message' => 'Success',
            'data' => $categories
        ];
    }

    public function show($id)
    {
        $category = $this->categoryUseCase->find($id);

        return view('home.category', ['category' => $category]);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        //... Validation here

        $category = $this->categoryUseCase->create($data);

        return view('home.categories');
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        //... Validation here

        $category = $this->categoryUseCase->update($id, $data);

        return view('home.categories');
    }

    public function destroy($id)
    {
        // $this->categoryUseCase->delete($id);
        
        return view('home.categorys');
    }
}