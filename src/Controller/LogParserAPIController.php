<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Request\LogParserAPIRequest;


class LogParserAPIController extends AbstractController
{
    private $validator;

    public function __construct(LogParserAPIRequest $validator){

        $this->validator = $validator;
    }
    
    #[Route('/count', name: 'app_log_parser_api', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {   
        $requestParam = [
            'serviceNames' => $request->query->get('serviceNames'),
            'startDate' => $request->query->get('startDate'),
            'endDate' => $request->query->get('endDate'),
            'statusCode' => $request->query->get('statusCode')
        ];

        $violations = $this->validator->validate($requestParam);

        if(count($violations) > 0 )  
            return $this->errorResponse($violations);


        return  $this->json([
            'response' =>  'processing api',
        ]);
         
        
    }

    private function errorResponse($violations){

        if (count($violations) > 0) {

            $errorMessages = [];

            foreach ($violations as $violation) {

                $errorMessages[] = [$violation->getPropertyPath(),$violation->getMessage()];
            }

            return $this->json([
                'errors' =>  $errorMessages,
            ]);
        }

        
    }


    
}
