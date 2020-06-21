<?php


namespace App\Helpers\Auth;


use App\Exceptions\GeneralException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Http;

class CaptchaHelper
{
    /**
     * Helper function to verify captcha token. Note: request must contain the 'captcha_token' key
     * @return mixed
     * @throws GeneralException
     */
    static public function verifyToken()
    {
        if(!config('access.captcha.registration'))
            return true;
        $token = request('captcha_token');

        $guzzle = new Client([
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'base_uri' => 'https://www.google.com',
            'verify' => true,
            'timeout' => 15, //timeout for request
        ]);
        try{
            // TODO: test this
            $response = Http::post('/recaptcha/api/siteverify', [
                'response' => $token,
                'secret' => config('no-captcha.secret'),
            ]);
//            $response = $guzzle->request('POST','/recaptcha/api/siteverify', [
//                'query' => [
//                    'response' => $token,
//                    'secret' => config('no-captcha.secret'),
//                ]
//            ]);
        }catch (ClientException $exception){
            $message = $exception->getMessage();
            throw new GeneralException($message, $exception->getCode());
        }

        $body = json_decode($response->getBody(), true);
        return data_get($body, 'success');

    }
}
