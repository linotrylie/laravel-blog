<?php

namespace App\Http\Controllers\Common;

use App\Constants\Constant;
use App\Entities\HomeMenu;
use App\Http\Controllers\Controller;
use App\Http\Requests\HomeMenuRequest;
use App\Repositories\HomeMenuRepository;

class HomeMenuController extends Controller
{
    //
    protected $homeMenuRequest;
    protected $homeMenuRepository;
    protected $homeMenuEntity;
    public function __construct(HomeMenuRequest $homeMenuRequest,
                                HomeMenuRepository $homeMenuRepository,
                                HomeMenu $homeMenuEntity)
    {
        parent::__construct();
        $this->homeMenuRequest = $homeMenuRequest;
        $this->homeMenuRepository = $homeMenuRepository;
        $this->homeMenuEntity = $homeMenuEntity;
        $this->middleware('guest')->except('index');
    }


    public function index()
    {
        $menuKey = Constant::HOME_MENU_LIST;
        $menuList = $this->redis->get($menuKey);
        if(is_null($menuList)) {
            $menuList = $this->homeMenuEntity::with('allHomeMenu')
                ->where('parent_id',0)
                ->where('status',1)
                ->get()->toArray();
            $this->redis->set($menuKey,json_encode($menuList),Constant::HOME_MENU_LIST_EXPIRED_TIME);
        }else{
            $menuList = json_decode($menuList,true);
        }
        if($this->homeMenuRequest->wantsJson()) {
            return success($menuList);
        }
        return $menuList;
    }
}
