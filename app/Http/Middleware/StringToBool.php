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

        if (isset($input['recurring'])) {
            if ('true' === $input['recurring'] || true === $input['recurring'] || '1' === $input['recurring']) {
                $input['recurring'] = true;
            } else {
                $input['recurring'] = false;
            }

            $request->replace($input);
        }

        if (isset($input['editAll'])) {
            if ('true' === $input['editAll'] || true === $input['editAll'] || '1' === $input['editAll']) {
                $input['editAll'] = true;
            } else {
                $input['editAll'] = false;
            }

            $request->replace($input);
        }

        return $next($request);
    }
}
