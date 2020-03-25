<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Illuminate\Support\Str;

/**
 * Class PostCriteria.
 *
 * @package namespace App\Criteria;
 */
class PostCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param string              $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $url = request()->getRequestUri();
        if(request()->filled('post_id')) {
            $postId = explode('_',request()->input('post_id'));
            $postId = $postId[0];
            request()->offsetSet('post_id',$postId);
        }
        if(Str::contains($url,  '/home/posts_list')) {
            return $this->list($model);
        }elseif (Str::contains($url,  '/home/post_info')) {
            return $this->info($model);
        }
        return $model;
    }

    public function list($model){
        $model = $model->where('status',1)
                ->where('type','post')
                ->orderBy('sort','desc')
                ->orderBy('id','desc');
        return $model;
    }

    public function info($model){
        $model = $model->with('user')->where('id',request()->input('post_id'))
            ->where('status',1);
        return $model;
    }
}
