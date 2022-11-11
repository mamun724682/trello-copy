<?php

namespace App\Services;

use App\Models\User;
use App\Traits\HandlePassportToken;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\DB;

class AuthService extends BaseService
{
    use HandlePassportToken;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * @param $data
     * @return array
     * @throws \Exception
     */
    public function register(array $data): array
    {
        try {
            DB::beginTransaction();
            // hash password
            $data['password'] = bcrypt($data['password']);

            $user = parent::storeOrUpdate($data);

            // Login to get access token
            auth()->login($user);
            $response = $this->createOnlyToken(auth()->user());

            DB::commit();
            return $response;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @param $data
     * @return array
     * @throws AuthenticationException
     */
    public function login(array $data): array
    {
        if (!auth()->attempt($data)) {
            throw new AuthenticationException(trans('auth.failed'));
        }

        return $this->createOnlyToken(auth()->user());
    }

    /**
     * @return null
     * @throws \Exception
     */
    public function logout()
    {
        $this->revokeAccessAndRefreshToken(auth()->user());

        return null;
    }
}
