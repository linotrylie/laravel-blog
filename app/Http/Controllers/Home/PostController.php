<?php

namespace App\Http\Controllers\Home;

use App\Criteria\PostCriteria;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Jobs\PostJob;
use App\Repositories\PostRepository;
use App\Validators\PostValidator;
use Illuminate\Support\MessageBag;
use Prettus\Validator\Exceptions\ValidatorException;

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
        $this->middleware('guest')->except('list','info');
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

    public function info()
    {
        $postId = $this->postRequest->input('post_id');
        try{
            $this->postValidator->with($this->postRequest->all())->passesOrFail('info');

            $this->postRepository->pushCriteria(new PostCriteria());

            $post = $this->postRepository->find($postId);

            if(empty($post['data'])) {
                throw new ValidatorException(new MessageBag());
            }

            PostJob::dispatch($postId,'views');

            if($this->postRequest->wantsJson()){
                return success($post['data']);
            }
            return redirect()->back()->with($post);
        }catch (ValidatorException $e) {
            if($this->postRequest->wantsJson()){
                return error(60001,config('httpcode.60001'));
            }
        }
        return redirect()->back()->withErrors($e->getMessageBag())->withInput();

    }

}
