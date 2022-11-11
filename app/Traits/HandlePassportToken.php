<?php

namespace App\Traits;

use App\Models\User;
use Laravel\Passport\RefreshTokenRepository;

trait HandlePassportToken
{
    /**
     * @param $user
     * @param $remember_me
     * @return array
     * @desc Create a new personal access token for the user
     */
    protected function createOnlyToken(User $user): array
    {
        // Create token
        $tokenData = $user->createToken('Personal Access Token');
        $accessToken = $tokenData->accessToken;

        $expiration = $tokenData->token->expires_at->diffInSeconds(now());

        return [
            'access_token' => $accessToken,
            'token_type'   => 'Bearer',
            'expires_in'   => $expiration
        ];
    }

    /**
     * @param $user
     * @return bool
     * @throws \Exception
     */
    private function revokeAccessAndRefreshToken(User $user): bool
    {
        try {
            $token = $user->token();

            /* --------------------------- revoke access token -------------------------- */
            $token->revoke();
            $token->delete();

            /* -------------------------- revoke refresh token -------------------------- */
            $refreshTokenRepository = app(RefreshTokenRepository::class);
            $refreshTokenRepository->revokeRefreshTokensByAccessTokenId($token->id);

            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
