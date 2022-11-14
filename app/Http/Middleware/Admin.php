<?php

namespace App\Http\Middleware;

use Closure;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
          if(auth()->user()->role_id == 1)
          {
            return $next($request);
          }
          else if(auth()->user()->role_id == 2)
          {
          return redirect('requests');
          }
          else if(auth()->user()->role_id == 3)
          {
          return redirect('for-dispatch');
          }
          else if(auth()->user()->role_id == 4)
          {
          return redirect('for-approval');
          }
          else if(auth()->user()->role_id == 5)
          {
          return redirect('dispatch-approval');
          }
          else if(auth()->user()->role_id == 6)
          {
          return redirect('fuels');
          }
          else if(auth()->user()->role_id == 7)
          {
          return redirect('fuels-report');
          }
    }
}
