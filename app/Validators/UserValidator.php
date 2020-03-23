<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class UserValidator.
 *
 * @package namespace App\Validators;
 */
class UserValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'username' => 'required | max:16 | min:3 | unique:users,username',
            'email'    => 'required | email | unique:users,email',
            'password' => 'required | max:16 | min:8 | confirmed',
            'phone'    => 'required | max:11 | min:10 | unique:users,phone',
        ],
        ValidatorInterface::RULE_UPDATE => [],
        'login' => [
            'phone'    => 'required | max:11 | min:10',
            'password' => 'required | max:16 | min:8'
        ],
        'reset_password' => [
            'email'    => 'required | email',
        ]
    ];
}
