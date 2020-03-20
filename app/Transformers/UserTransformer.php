<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\User;
use Carbon\Carbon;
/**
 * Class UserTransformer.
 *
 * @package namespace App\Transformers;
 */
class UserTransformer extends TransformerAbstract
{
    /**
     * Transform the User entity.
     *
     * @param \App\Entities\User $model
     *
     * @return array
     */
    public function transform(User $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */
            'name'       => $model->name,
            'email'      => $model->email,
            'created_at' => Carbon::parse($model->created_at)->toDateTimeString(),
            'updated_at' => Carbon::parse($model->updated_at)->toDateTimeString()
        ];
    }
}
