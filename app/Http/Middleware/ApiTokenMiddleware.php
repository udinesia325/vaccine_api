<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ApiTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header("token");
        $authenticate = false;

        if ($token) {
            $user = User::where("token", $token)->first();
            if ($user) {
                $authenticate = true;
                Auth::login($user);
            }
        } else {
            $authenticate = false;
        }
        if ($authenticate) {
            return $next($request);
        }
        return response([
            "message" => "unauthorized"
        ], 401);
    }
}
