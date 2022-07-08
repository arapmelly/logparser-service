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

    public function validate($requestParam): ConstraintViolationListInterface
    {  
        return $this->validator->validate($requestParam, $this->getConstraints());
    }

    private function getConstraints()
    {
        return  new Assert\Collection([
            'serviceNames' => [new Assert\NotBlank, new Assert\NotNull()],
            'startDate' => [new Assert\notBlank, new Assert\NotNull(), new Assert\Date()],
            'endDate' => [new Assert\notBlank, new Assert\NotNull(), new Assert\Date()],
            'statusCode' => [new Assert\notBlank, new Assert\NotNull(), new Assert\Regex([
                'pattern' => '/^[1-5][0-9][0-9]$/',
                'match' => true,
                'message' => 'must be a valid http status code',
            ])],
        ]);
    }


}