<?php

namespace App\Http\Middleware;

use App\Models\Language;
use Closure;
use Illuminate\Http\Request;

class Localization
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
        $locale = $request->query('lang', $request->header('Accept-Language'));
        if ($locale) {
            if (Language::where('code', $locale)->exists()) {
                app()->setLocale($locale);
            } else {
                return response()->json(['error' => 'Unsupported locale: '.$locale], 406);
            }
        }

        return $next($request);
    }
}
