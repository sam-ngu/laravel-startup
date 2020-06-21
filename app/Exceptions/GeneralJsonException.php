<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class GeneralJsonException extends Exception
{

    protected $code = 422;
    /**
     * Report the exception.
     *
     * @return void
     */
     public function report()
     {
        //
    }


    /**
     * Render the exception as an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request)
    {
        return JsonResponse::create(['error' => $this->getMessage()], $this->code);
    }
}
