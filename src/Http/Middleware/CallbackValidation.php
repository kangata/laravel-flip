<?php

namespace QuetzalStudio\Flip\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CallbackValidation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (! $this->isValidToken($request)) {
            return response()->json([
                'message' => 'Forbidden.',
            ], 403);
        }

        return $next($request);
    }

    /**
     * Check validation token
     *
     * @param Request $token
     * @return boolean
     */
    private function isValidToken(Request $request)
    {
        return $request->get('token') == config('flip.validation_token');
    }
}
