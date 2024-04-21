<?php

namespace App\Http\Middleware;

use App\Traits\LogTrait;
use Closure;
use Illuminate\Http\Request;

class LogRequest
{
    use LogTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $this->startLog(
            [
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'parameters' => $request->all(),
            ]
        );

        return $next($request);
    }
}
