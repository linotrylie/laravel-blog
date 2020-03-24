<?php

namespace App\Http\Controllers\Home;

use App\Criteria\PostCriteria;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Repositories\PostRepository;
use App\Validators\PostValidator;

class PostController extends Controller
{
    protected $postRequest;
    protected $postRepository;
    protected $postValidator;
    public function __construct(PostRequest $postRequest,PostValidator $postValidator,PostRepository $postRepository)
    {
        parent::__construct();
        $this->postRepository = $postRepository;
        $this->postRequest = $postRequest;
        $this->postValidator = $postValidator;
        $this->middleware('guest')->except('list');
    }

    public function list()
    {
        $this->postRepository->pushCriteria(new PostCriteria());
        $posts = $this->postRepository->paginate($this->postRequest->input('page_size',10));

        if($this->postRequest->wantsJson()){
            return success($posts);
        }
        dd($posts);
    }

}
