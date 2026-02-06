<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // লগইন না থাকলে লগইন পেজে পাঠাবে
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        // যদি ইউজারের system_admin রোল $roles এর মধ্যে থাকে
        if (in_array($user->system_admin, $roles)) {
            return $next($request); // অনুমোদিত, পরবর্তী middleware বা কন্ট্রোলার চালাবে
        }

        // অনুমোদিত না হলে 403
        abort(403, 'Unauthorized');
    }
}
