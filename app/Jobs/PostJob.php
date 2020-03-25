<?php

namespace App\Jobs;

use App\Repositories\PostRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
//use App\Jobs\Middleware\RateLimited;
use Illuminate\Support\Facades\Log;

class PostJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $postId;
    private $field;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($postId,$field)
    {
        //$this->postRepository = new PostRepositoryEloquent($this->postRepository);
        $this->postId = $postId;
        $this->field = $field;
    }

//    /**
//     * 获取任务应该通过的中间件
//     *
//     * @return array
//     */
//    public function middleware()
//    {
//        return [new RateLimited];
//    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $post = app(PostRepository::class)->skipPresenter()->find($this->postId);

        $num = 0;

        if(isset($post[$this->field])) {
            $num = $post[$this->field]+1;
        }else{
            Log::error('update post data views error id：'.$this->postId);
        }

        try {
            app(PostRepository::class)->update([$this->field => $num], $this->postId);
        }catch (\Exception $e) {
            Log::error('update post data views error id：'.$this->postId." {$this->field} ：{$num}  {$post}");
        }

    }
}
