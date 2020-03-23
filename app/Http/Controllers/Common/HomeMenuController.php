<?php

namespace App\Http\Controllers\Common;

use App\Entities\HomeMenu;
use App\Http\Controllers\Controller;
use App\Http\Requests\HomeMenuRequest;
use App\Repositories\HomeMenuRepository;
use Illuminate\Http\Request;

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

//        dd($this->homeMenuEntity::with('allHomeMenu')->where('parent_id',0)->get()->toArray());
        $menuList = $this->homeMenuEntity::with('allHomeMenu')
            ->where('parent_id',0)
            ->where('status',1)
            ->get()->toArray();
        return success($menuList);
    }
}
