<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Post;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Tool\MarkdownTypecho;
/**
 * Class PostTransformer.
 *
 * @package namespace App\Transformers;
 */
class PostTransformer extends TransformerAbstract
{
    /**
     * Transform the Post entity.
     *
     * @param \App\Entities\Post $model
     *
     * @return array
     */
    public function transform(Post $model)
    {
        $url = request()->getRequestUri();

        $model->text = str_replace('<!--markdown-->','',$model->text);

        $model->text = MarkdownTypecho::convert($model->text);

        if(Str::contains($url,  '/home/posts_list')) {
            return $this->list($model);
        }elseif (Str::contains($url,  '/home/post_info')) {
            return $this->info($model);
        }
        return [];
    }


    public function list(Post $model) {

        $model->text = mb_substr(strip_tags($model->text), 0,200).'......';
        return [
            'id'         => $model->id,
            'user_id'    => (int) $model->user_id,
            'category_id'=> (int) $model->category_id,
            'title'      => $model->title,
            'text'       => $model->text,
            'sort' => $model->sort ,
            'type' => $model->type ,
//            'password' => $model->password ,
            'views' => $model->views ,
            'comments' => $model->comments ,
            'shares' => $model->shares ,
            'follows' => $model->follows ,
            /* place your other model properties here */
            'created_at' => Carbon::parse($model->created_at)->toDateTimeString(),
            'updated_at' => Carbon::parse($model->updated_at)->toDateTimeString()
        ];
    }

    public function info(Post $model) {
        return [
            'id'         => $model->id,
            'user_id'    => (int) $model->user_id,
            'category_id'=> (int) $model->category_id,
            'title'      => $model->title,
            'text'      => $model->text,
            'sort' => $model->sort ,
            'type' => $model->type ,
            'password' => $model->password,
            'views' => $model->views ,
            'comments' => $model->comments ,
            'shares' => $model->shares ,
            'follows' => $model->follows ,
            'auth_name' => $model->user->username,
            /* place your other model properties here */
            'created_at' => Carbon::parse($model->created_at)->toDateTimeString(),
            'updated_at' => Carbon::parse($model->updated_at)->toDateTimeString()
        ];
    }
}
