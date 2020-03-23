<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class HomeMenu.
 *
 * @package namespace App\Entities;
 */
class HomeMenu extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'menu_name',
        'router',
        'parent_id',
        'sort',
        'status'
    ];

    public function homeMenu()
    {
        return $this->hasMany(HomeMenu::class,'parent_id','id');
    }

    public function allHomeMenu()
    {
        return $this->homeMenu()->with('allHomeMenu');
    }

}
