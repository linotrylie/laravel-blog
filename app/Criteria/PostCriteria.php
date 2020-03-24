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
        if(Str::contains($url,  '/home/posts_list')) {
            return $this->list($model);
        }
        return $model;
    }

    public function list($model){
        $model = $model->where('status',1)
                ->where('type','post')
                ->orderBy('id','desc');
        return $model;
    }
}
