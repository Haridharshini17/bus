<?php

namespace App\Service;

class AuthService
{

	/**
	 * Method to get form details.
	 */
    public function getFormDetails($request, $createForm) 
    {
        $createForm->handleRequest($request);
        $createForm->submit(json_decode($request->getContent(), true));
        if ($createForm->isSubmitted() && $createForm->isValid()) {
            $formDetails = $createForm->getData();
            
            return $formDetails;
        }

        return new Response(Response::INVALID_DETAILS); 
    }
}
