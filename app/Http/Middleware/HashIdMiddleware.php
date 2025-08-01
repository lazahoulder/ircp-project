<?php

namespace App\Http\Middleware;

use App\Services\HashidsService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HashIdMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $hashidsService = new HashidsService();

        //dump($request->route()->parameters());

        foreach ($request->route()->parameters() as $key => $value) {
            if (strpos($key, 'id') !== false && !is_numeric($value)) {
                $decodedId = $hashidsService->decode($value);
                if ($decodedId !== null) {
                    $request->route()->setParameter($key, $decodedId);
                }
            }
        }

        //dd($request->route()->parameters());
        return $next($request);
    }
}
