<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\HomeMenu;

/**
 * Class HoneMenuTransformer.
 *
 * @package namespace App\Transformers;
 */
class HomeMenuTransformer extends TransformerAbstract
{
    /**
     * Transform the HomeMenu entity.
     *
     * @param \App\Entities\HomeMenu $model
     *
     * @return array
     */
    public function transform(HomeMenu $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */
            'menu_name'       => $model->menu_name,
            'router'     => $model->router,
            'status'    => $model->status,
            'parent_id' => $model->parent_id,
            'sort'      => $model->sort,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
