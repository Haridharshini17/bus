<?php

namespace App\Service;

class BusService
{

    /**
     * Method to format the arrival and destination time.
     */
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

    /**
     * Method to submit and get form details.
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
