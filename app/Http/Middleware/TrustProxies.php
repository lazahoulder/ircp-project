<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

class TrustProxies extends Middleware
{
    /**
     * Liste des proxys de confiance.
     *
     * Ici, * signifie faire confiance à tous (Railway, etc.)
     */
    protected $proxies = '*';

    /**
     * En-têtes utilisés pour déterminer les informations du client derrière le proxy.
     */
    protected $headers =
        SymfonyRequest::HEADER_X_FORWARDED_FOR |
        SymfonyRequest::HEADER_X_FORWARDED_HOST |
        SymfonyRequest::HEADER_X_FORWARDED_PORT |
        SymfonyRequest::HEADER_X_FORWARDED_PROTO;
}
