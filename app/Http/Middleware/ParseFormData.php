<?php

namespace App\Http\Middleware;

use App\Helpers\Middleware\ParseInputStream;
use Closure;

class ParseFormData
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
//        if ($request->method() == 'POST' OR $request->method() == 'GET') {
//            return $next($request);
//        }

        if($request->method() === 'GET'){
            return $next($request);
        }
        if ($request->method() === 'POST') {
            if($request->isJson()){
                return $next($request);
            }
            // potential form data
            $data = $request->toArray();

            // convert to empty array string to empty array.
            $data = ParseInputStream::convertEmptyArrayStringToArray($data)
            $request->request->add($data);
            return $next($request);

        }

        if (preg_match('/multipart\/form-data/', $request->headers->get('Content-Type')) or
            preg_match('/multipart\/form-data/', $request->headers->get('content-type'))
        ) {
            $params = array();
            new ParseInputStream($params);
            $request->request->add($params);

        }

        return $next($request);
    }
}
