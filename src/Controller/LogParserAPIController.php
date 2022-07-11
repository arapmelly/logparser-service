<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Request\LogParserAPIRequest;
use App\Service\LogParserService;


class LogParserAPIController extends AbstractController
{
    private $validator;

    private $logParserService;

    public function __construct(LogParserAPIRequest $validator, LogParserService $logParserService){

        $this->validator = $validator;
        $this->logParserService = $logParserService;
    }
    
    #[Route('/count', name: 'app_log_parser_api', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {   

        if(count($request->query->all()) > 0){

            $violations = $this->validator->validate($request->query->all());

            if(count($violations) > 0 )  
               return $this->errorResponse($violations);

        }else {

            return $this->json([ 'errors' =>  'no request parameter' ]);
        }
            

        $logCount = $this->logParserService->getLogCount($request->query->all());

        return  $this->json($logCount);
         
        
    }

    private function errorResponse($violations){

        foreach ($violations as $violation) {
            $errorMessages[] = [$violation->getPropertyPath(),$violation->getMessage()];
        }

        return $this->json([ 'errors' =>  $errorMessages ]);   
    }



    
}
