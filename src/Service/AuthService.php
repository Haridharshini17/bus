<?php

namespace App\Service;

class AuthService
{
    public function submitForm($request, $createForm) 
    {
        $createForm->handleRequest($request);
        $createForm->submit(json_decode($request->getContent(), true)); 
    } 
}
