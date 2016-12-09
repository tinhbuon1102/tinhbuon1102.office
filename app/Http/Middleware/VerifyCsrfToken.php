<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'ShareUser/Dashboard/HostSetting/hostingImages',
		'/ShareUser/Dashboard/PaypalSuccess',
		'/ShareUser/Dashboard/PaypalIpn',
		'/ShareUser/Dashboard/PaypalCancel',
    ];
}
