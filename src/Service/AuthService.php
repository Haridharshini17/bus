<?php

namespace App\Service;

class AuthService
{
    public function submitForm($request, $createForm) 
    {
        $createForm->handleRequest($request);
        $createForm->submit(json_decode($request->getContent(), true)); 
    }

    public function dateFormat($response)
    {
        array_walk(
            $response, function ($value,$key) use (&$response) {
                $response[$key]['arrival_time'] = date_format($value['arrival_time'], 'H:i:s');
                $response[$key]['destination_time'] = date_format($value['destination_time'], 'H:i:s');
            }
        );
        return json_encode($response);
    }
}
