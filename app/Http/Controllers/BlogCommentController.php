<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogCommentRequest;
use App\UseCases\BlogComment\BlogCommentUseCase;
use Illuminate\Http\Request;

class BlogCommentController extends Controller
{
    protected $blogCommentUseCase;

    public function __construct(BlogCommentUseCase $blogCommentUseCase)
    {
        $this->blogCommentUseCase = $blogCommentUseCase;
    }

    public function index()
    {
        try {
            $blogComments = $this->blogCommentUseCase->getAll();
            return response()->json(['code'=> 200,'data' => $blogComments], 200);
        } catch (\Exception $e) {
            return response()->json(['code' => 500, 'error' => $e->getMessage()], 500);
        }
    }

    public function show($blog_id, Request $request)
    {
        $query = $request->query();

        $blogComments = $this->blogCommentUseCase->getCommentsByBlogId($blog_id, $query);

        return [
            'code' => 200,
            'message' => 'Success',
            'data' => $blogComments
        ];
    }

    public function detail($blog_id, $parent_id)
    {

        $blogComments = $this->blogCommentUseCase->getCommentsByParentId($blog_id, $parent_id);

        return [
            'code' => 200,
            'message' => 'Success',
            'data' => $blogComments
        ];
    }

    public function store(BlogCommentRequest $request)
    {
        $data = $request->all();

        $blogComment = $this->blogCommentUseCase->create($data);

        return [
            'code' => 200,
            'message' => 'Create successfully',
            'data' => $blogComment
        ];
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        //... Validation here

        $blogComment = $this->blogCommentUseCase->update($id, $data);

        return view('home.blogComments');
    }

    public function destroy($id)
    {
        // $this->blogCommentUseCase->delete($id);

        return view('home.blogComments');
    }
}
