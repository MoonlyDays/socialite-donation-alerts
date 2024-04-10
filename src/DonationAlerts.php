<?php

namespace MoonlyDays\SocialiteDonationAlerts;

use GuzzleHttp\Exception\GuzzleException;
use SocialiteProviders\Manager\OAuth2\AbstractProvider;
use SocialiteProviders\Manager\OAuth2\User;

class DonationAlerts extends AbstractProvider
{
    protected function getAuthUrl($state): string
    {
        return $this->buildAuthUrlFromBase("https://www.donationalerts.com/oauth/authorize", $state);
    }

    protected function getTokenUrl(): string
    {
        return "https://www.donationalerts.com/oauth/token";
    }

    /**
     * @throws GuzzleException
     */
    protected function getUserByToken($token)
    {
        $res = $this->getHttpClient()->get("https://www.donationalerts.com/api/v1/user/oauth", [
            "headers" => [
                "Authorization" => "Bearer " . $token
            ]
        ]);

        return json_decode($res->getBody(), true);
    }

    protected function mapUserToObject(array $user): User
    {
        return (new User())->setRaw($user)->map([
            'id' => $user['id'],
            'code' => $user['code'],
            'name' => $user['name'],
            'avatar' => $user["avatar"],
            "email" => $user["email"],
            "socket_connection_token" => $user["socket_connection_token"]
        ]);
    }

    protected function formatScopes(array $scopes, $scopeSeparator): string
    {
        return implode(' ', $scopes);
    }
}