<?php

namespace Ignite\Users\Library\Traits;

use GuzzleHttp\Client;
use Ignite\Users\Entities\User;

trait PassportCustomsTrait
{
    /*
     * Generates permissions given a simple definition
     */
    public function customs()
    {
        $client = new Client([
            'base_uri' => url('/'),
            'timeout'  => 3.142,
        ]);

        try
        {
            $data =  $this->getRequestData();

            $response = $client->post('/oauth/token', $data['form_data']);

            $customs = json_decode((string) $response->getBody());

            session([
                'passport' => [
                    'access_token' => $customs->access_token,
                    'refresh_token' => $customs->refresh_token,
                ]
            ]);

            $customs->user = $data['user'];

            return $customs;
        }
        catch(\Exception $e)
        {
            // dd($e->getMessage());
            session()->flash('errors', ["customs_error" => $e->getMessage()]);
        }
    }

    /*
     * Get the request data used to generate a token
     */
    public function getRequestData()
    {
        $user = User::whereUsername(request('username'))->first();

        return [
            'user' => $user,
            'form_data' => [
                'form_params' => array_merge([
                    'username' => $user->email,
                    'password' => request('password')
                ], mconfig('users.config.passport'))
            ]
        ];
    }
}
