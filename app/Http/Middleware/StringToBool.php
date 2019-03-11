<?php

namespace App\Http\Middleware;

use Closure;

class StringToBool
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $input = $request->all();

        if ($input['recurring']) {
            if ('true' === $input['recurring'] || true === $input['recurring']) {
                $input['recurring'] = true;
            } else {
                $input['recurring'] = false;
            }

            $request->replace($input);
        }

        return $next($request);
    }
}
