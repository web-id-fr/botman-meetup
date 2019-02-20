<?php

namespace App\Http\Middleware;

use BotMan\BotMan\Interfaces\Middleware\Matching;
use BotMan\BotMan\Messages\Incoming\IncomingMessage;
use Closure;

class BotmanMatchingMiddleware implements Matching
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
    }

    /**
     * @param IncomingMessage $message
     * @param string          $pattern
     * @param bool            $regexMatched Indicator if the regular expression was matched too
     *
     * @return bool
     */
    public function matching(IncomingMessage $message, $pattern, $regexMatched)
    {
        return 'toto' === $message->getText();
    }
}
