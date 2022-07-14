<?php

namespace App\Request;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class LogParserAPIRequest 
{
  
    protected $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;

    }

    public function validate($requestParam)
    {  
        $errors = [];
    
        if(isset($requestParam['serviceNames'])){
            $violations = $this->validator->validate($requestParam['serviceNames'], new Assert\NotBlank()); 
            if(count($violations) > 0)
                $errors['serviceNames'] = $this->getErrorMessages($violations);
        }

        if( isset($requestParam['statusCode'])){
            $violations = $this->validator->validate($requestParam['statusCode'], [new Assert\NotBlank(), new Assert\Regex([
                'pattern' => '/^[1-5][0-9][0-9]$/',
                'match' => true,
                'message' => 'must be a valid http status code',
            ])]);

            if(count($violations) > 0)
                $errors['statusCode'] = $this->getErrorMessages($violations);
              
        }

        if(isset($requestParam['startDate'])){
            $violations = $this->validator->validate($requestParam['startDate'], [new Assert\NotBlank(), new Assert\Date()]);  
            if(count($violations) > 0)
                $errors['startDate'] = $this->getErrorMessages($violations);
        }

        if(isset($requestParam['endDate'])){
            $violations = $this->validator->validate($requestParam['endDate'], [new Assert\NotBlank(), new Assert\Date()]); 
            if(count($violations) > 0)
                $errors['endDate'] = $this->getErrorMessages($violations); 
        }

        return $errors;
        
    }

    /**
     * get error messages
     */
    private function getErrorMessages($violations){

        $errors = [];

        if(count($violations) > 0){
            foreach($violations as $violation){
                $errors[] =  $violation->getMessage();
            }     
        }

        return $errors;
    }


    /**
     * validate servieNames
     * 
     */
    public function validateServiceNames($requestParam){


        if(isset($requestParam['serviceNames'])){
            $violations = $this->validator->validate($requestParam['serviceNames'], new Assert\NotBlank());
            
            if(count($violations) > 0){
                foreach ($violations as $violation) {
                    if($violation !== null) {
                        $errorMessages[] = [$violation->getPropertyPath(),$violation->getMessage()];
                    }
                    
                }

                return $errorMessages;
            }
        }

        return null;

    }
    
    private function getConstraints()
    {
        return  new Assert\Collection([
            'serviceNames' => [],
            'startDate' => [new Assert\Date()],
            'endDate' => [new Assert\Date()],
            'statusCode' => [new Assert\Regex([
                'pattern' => '/^[1-5][0-9][0-9]$/',
                'match' => true,
                'message' => 'must be a valid http status code',
            ])],
        ]);
    }


}