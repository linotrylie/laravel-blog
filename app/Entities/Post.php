<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Post.
 *
 * @package namespace App\Entities;
 */
class Post extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'text',
        'sort',
        'type',
        'password',
        'views',
        'comments',
        'shares',
        'follows',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
