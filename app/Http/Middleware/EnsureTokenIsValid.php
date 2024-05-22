<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Cache;
use Redirect;
class EnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
      
        if(Cache::get('token') == null ){
    
            $this->generateCode();
        }
        return $next($request);
    }
    public function generateCode(){
       
        $url = 'https://authentication.logmeininc.com/oauth/authorize?client_id='.env('GOTO_WEBINAR_CLIENT_ID').'&response_type=code&redirect_uri='.url('/getToken'); 
    
        return Redirect::away($url);
    }



}
