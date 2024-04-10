<?php

namespace MoonlyDays\LaravelDonationAlerts;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Fluent;
use Illuminate\Support\Str;

class DonationAlerts
{
    private Fluent $config;

    public function __construct(array $config)
    {
        $this->config = fluent($config);
    }

    private function getClientId()
    {
        return $this->config->get("auth.client_id");
    }

    private function getClientSecret()
    {
        return $this->config->get("auth.client_secret");
    }

    public function redirectToLogin(array $scopes = [], string $backUrl = null): RedirectResponse
    {
        if (empty($backUrl)) {
            $backUrl = request()->getRequestUri();
        }

        $url = $this->buildUrl("https://www.donationalerts.com/oauth/authorize", [
            "client_id" => $this->getClientId(),
            "redirect_uri" => $backUrl,
            "response_type" => "code",
            "scope" => join(" ", $scopes)
        ]);

        return redirect()->to($url);
    }

    public function validate()
    {
        $code = request("code");
        if (empty($code)) abort(400, "Authorization code was not provided");

        $token = $this->getAccessToken($code);
    }

    private function getAccessToken(string $code)
    {
        $res = Http::post("https://www.donationalerts.com/oauth/token", [
            "grant_type" => "authorization_code",
            "client_id" => $this->getClientId(),
            "client_secret" => $this->getClientSecret(),
            "redirect_uri" => "http://localhost:8000/login/back",
            "code" => $code
        ]);

        dd($res);
    }

    function buildUrl($to, array $params = [], array $additional = []): string
    {
        return Str::finish(url($to, $additional), '?') . Arr::query($params);
    }
}