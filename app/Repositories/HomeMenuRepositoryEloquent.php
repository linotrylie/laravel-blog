<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\HomeMenuRepository;
use App\Entities\HomeMenu;
use App\Validators\HomeMenuValidator;

/**
 * Class HomeMenuRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class HomeMenuRepositoryEloquent extends BaseRepository implements HomeMenuRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return HomeMenu::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
