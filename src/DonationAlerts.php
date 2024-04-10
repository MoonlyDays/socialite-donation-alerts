<?php

namespace MoonlyDays\LaravelDonationAlerts;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Fluent;

class DonationAlerts
{
    private Fluent $config;

    public function __construct(array $config) {
        $this->config = fluent($config);
    }

    private function getClientId() {
        return $this->config->get("auth.client_id");
    }

    private function getClientSecret() {
        return $this->config->get("auth.client_secret");
    }

    private function redirectToLogin(): RedirectResponse {


    }
}