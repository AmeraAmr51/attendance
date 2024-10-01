<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use App\Http\Traits\HttpResponse;
use App\Traits\ResponseTrait;

class UpdateTokenExpirationMiddleware
{
    use ResponseTrait;
    public function handle($request, Closure $next)
    {
        $token = $request->header('Authorization');
        if (!$token) {
            return $this->sendError([],'Unauthorized',401);
        }else{
            $token = auth()->user()->token();
            $minutes = Carbon::now()->diffInMinutes(Carbon::parse($token->updated_at));
            if ($minutes < 1000) {
                $token->update(["updated_at" => Carbon::now()->format('Y-m-d H:i:s')]);
                return $next($request);
            }
            else {
                return $this->sendError([],'Unauthorized',401);
            }
        }
    }

}