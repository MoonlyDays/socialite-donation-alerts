<?php

namespace MoonlyDays\SocialiteDonationAlerts;

use SocialiteProviders\Manager\SocialiteWasCalled;

class DonationAlertsExtendSocialite
{
    public function handle(SocialiteWasCalled $socialiteWasCalled): void
    {
        $socialiteWasCalled->extendSocialite('donationalerts', Provider::class);
    }
}