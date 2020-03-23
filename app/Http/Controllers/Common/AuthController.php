<?php

namespace App\Http\Controllers\Common;

use App\Constants\Constant;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Repositories\UserRepository;
use App\Validators\UserValidator;
use Illuminate\Support\MessageBag;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Auth;
use Carbon\Carbon;


class AuthController extends Controller
{
    protected $loginRequest;
    protected $userValidator;
    protected $userRepository;

    /**
     * AuthController constructor.
     * @param LoginRequest $loginRequest
     * @param UserValidator $userValidator
     * @param UserRepository $userRepository
     * @param UserApiTokenRepository $apiTokenRepository
     */
    public function __construct(LoginRequest $loginRequest,
                                UserValidator $userValidator,
                                UserRepository $userRepository)
    {
        parent::__construct();
        $this->loginRequest = $loginRequest;
        $this->userValidator = $userValidator;
        $this->userRepository = $userRepository;
        $this->middleware('guest')->except('login','register');
    }

    /**
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function register()
    {
        try{
            $this->userValidator->with($this->loginRequest->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $user = $this->userRepository->create($this->loginRequest->all());

            if ($this->loginRequest->wantsJson()) {
                return success($user['data']);
            }

            return redirect()->back()->with($user);
        }catch (ValidatorException $e) {
            if ($this->loginRequest->wantsJson()) {
                return error(50001,$e->getMessageBag());
            }
        }
        return redirect()->back()->withErrors($e->getMessageBag())->withInput();
    }

    /**
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function login()
    {
        try{
            $this->userValidator->with($this->loginRequest->all())->passesOrFail('login');

            if(!$this->check()) {
                throw new ValidatorException(new MessageBag([]));
            }

            $user = $this->guard()->user()->toArray();

            $apiToken = bcrypt(random_int(0, 9999));
            $expiredTime = Constant::USER_TOKEN_EXPIRED_TIME;

            $userKey =  sprintf(Constant::REDIS_USER,$user['id']);
            $this->redis->set($userKey,json_encode($user));

            $userTokenKey = sprintf(Constant::REDIS_USER_TOKEN,$user['id']);
            $this->redis->set($userTokenKey,$apiToken,$expiredTime);

            $user['token'] = $apiToken;
            if ($this->loginRequest->wantsJson()) {
                return success($user);
            }

            return redirect()->back()->with($user);
        }catch (ValidatorException $e) {
            if($this->loginRequest->wantsJson()) {
                return error(50002,config('httpcode.50002'));
            }
        }
        return redirect()->back()->withErrors($e->getMessageBag())->withInput();
    }

    /**
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        $this->guard()->logout();

        $userId = $this->loginRequest->input('user_id');

        $userKey = sprintf(Constant::REDIS_USER,$userId);
        $this->redis->set($userKey, null);

        $userTokenKey = sprintf(Constant::REDIS_USER_TOKEN,$userId);
        $this->redis->set($userTokenKey,'');

        if ($this->loginRequest->wantsJson()) {
            return success();
        }
        return redirect()->back()->with(['user_id'=>$userId]);
    }

    /**
     * @return mixed
     */
    private function check()
    {
        return $this->guard()->attempt(
            $this->loginRequest->only('phone', 'password'),
            $this->loginRequest->has('remember')
        );
    }

    /**
     * @return mixed
     */
    public function guard()
    {
        return Auth::guard();
    }



}
