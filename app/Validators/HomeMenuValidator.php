<?php
/**
 * Created by PhpStorm.
 * User: edz
 * Date: 2020/3/23
 * Time: 0:02
 */

namespace App\Validators;
use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;


class HomeMenuValidator extends  LaravelValidator
{

    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'menu_name' => 'required | max:50 | min:3 | unique:home_menus,menu_name',
            'router'    => 'required | unique:home_menus,router',
        ],
        ValidatorInterface::RULE_UPDATE => [],
    ];
}