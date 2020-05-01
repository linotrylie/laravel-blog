<?php

namespace App\Repositories;

use App\Constants\Constant;
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

    /**
     * 获取菜单
     * @return mixed
     */
    public function getMenuList() {
        $menuKey = Constant::HOME_MENU_LIST;
        $menuList = $this->redis->get($menuKey);
        if(is_null($menuList) || $menuList === false) {
            $menuList = $this->homeMenuEntity::with('allHomeMenu')
                ->where('parent_id',0)
                ->where('status',1)
                ->get()->toArray();
            $this->redis->set($menuKey,json_encode($menuList),Constant::HOME_MENU_LIST_EXPIRED_TIME);
        }else{
            $menuList = json_decode($menuList,true);
        }
        return $menuList;
    }
}
