<?php

namespace App\Services\Auth;

use App\Contracts\UserContract;
use App\Events\UserRegistered;
use App\Repositories\UserRepository;
use App\User;
use Illuminate\Auth\AuthManager;
use Illuminate\Auth\Passwords\PasswordBrokerManager;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class AuthService
 * @package App\Services
 */
class AuthService
{
    /**
     * @var \Illuminate\Auth\AuthManager
     */
    protected $authManager;
    /**
     * @var \Illuminate\Auth\Passwords\PasswordBrokerManager
     */
    protected $passwordBrokerManager;
    /**
     * @var \App\User
     */
    protected $user;

    /**
     * @var UserRepository
     */
    protected $userRepository;


    /**
     * AuthService constructor.
     * @param AuthManager $authManager
     * @param PasswordBrokerManager $passwordBrokerManager
     * @param User $user
     * @param UserContract $userRepository
     */
    public function __construct(
        AuthManager $authManager,
        PasswordBrokerManager $passwordBrokerManager,
        User $user,
        UserContract $userRepository
    ) {
        $this->authManager           = $authManager;
        $this->passwordBrokerManager = $passwordBrokerManager;
        $this->user                  = $user;
        $this->userRepository        = $userRepository;
    }

    /**
     * @param $credentials
     *
     * @return bool
     */
    public function authenticate($credentials)
    {
        return $this->authManager
            ->guard()
            ->attempt($credentials);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function register(Request $request)
    {

        $merge = array(
            'password'       => bcrypt($request->get('password')),
            'remember_token' => Str::random(10),
            'api_token'      => $this->generateAccessToken(),
        );

        $request = array_merge($request->all(), $merge);

        $registeredUser = $this->user->create($request);

        $code = $this->generateVerifyCode();
        event(new UserRegistered($registeredUser, $code));

        $registeredUser->update([
            'verification_code' => $code
        ]);

        return $registeredUser;
    }

    public function verify(Request $request)
    {

        $user = $this->userRepository->findByCode($request->email, $request->code);

        if ( !$user ) {
            throw new NotFoundHttpException('User not  found or already verify.');
        }
        $user->update([
            'is_verified' => true,
            'verification_code' => null
        ]);

        return $user;

    }

    /**
     * @param User $user
     */
    public function updateAccessToken(User $user)
    {
        $token = $this->generateAccessToken();

        $user->update(['api_token' => $token]);
    }


    /**
     * @return string
     */
    public function generateAccessToken(): string
    {
        return Str::random(60);
    }

    /**
     * @return string
     */
    private function generateVerifyCode(): string
    {
        return Str::random(5);
    }


    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function logout(Request $request)
    {
        return $request->user()->token()->revoke();
    }

}
