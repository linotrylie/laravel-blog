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
        $menuList = $this->homeMenuRepository->getMenuList();
        if($this->homeMenuRequest->wantsJson()) {
            return success($menuList);
        }
        return redirect()->back()->with($menuList);
    }
}
