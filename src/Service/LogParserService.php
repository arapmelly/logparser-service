<?php
namespace App\Service;

use App\Entity\LogEntry;
use App\Repository\LogEntryRepository;

use App\LogParser\LogIterator;
use App\LogParser\LogParser;

use App\LogParser\Exception\ParserException;




/**
 * This is the class that loads logfile, parse log file and insert parsed data to database
 */

class LogParserService {

    
    private $resumeProcessing;

    private $pattern;

    private $logParser;

    private $logFile;

    private $date;

    private $time;

    private $service;

    private $requestType;

    private $statusCode;

    private $httpHeader;

    private $lineCount;

    private $repository;

    private $startLine;

   

    public function __construct(LogEntryRepository $repository) 
    {
        $this->lineCount = 1;
        $this->repository = $repository;
        $this->logFile = 'logs.txt';
        $this->pattern = '/(?<service>\S+)\s+(?<line_1>\S+)\s+(?<line_2>\S+)\s+(?<datetime>\S+)\s+(?<gmt>\S+)\s+(?<method>\S+)\s+(?<path>\S+)\s+(?<http_header>\S+)\s+(?<response_code>\d+)/';
        $this->resumeProcessing = true;
       
        $this->logParser = new LogParser($this->pattern);
        
       $this->startLine = $this->getStartLine();
        
        
    }

    
    public function processLogFile(){

        $parsedData = [];

       
     
        foreach(new LogIterator($this->logFile, $this->logParser, $this->startLine, true) as $data){


                if($this->setLogData($data)){
                    $this->saveLogEntry();
                    array_push($parsedData, ['line'=>$this->startLine, 'data'=>$data]);
                    $this->lineCount++;   
                };  
                
        }

        return $this->lineCount;

    }


    /**
     * get the last line number
     */
    private function getStartLine(){

        //checks if there are db entries for the log file and returns the last line count
        //returns zero when no entiries exist.
        $lastItem = $this->repository->getLastRow();

        

        if($lastItem){
            
            $lastLine = $lastItem->getLineNumber();
            $startLine = $lastLine + 1;
            
        } else {

            $startLine = 0;
        }

        return $startLine;

    }

    

    public function setLogData($data){

        
        $datetime = $data['datetime'].' '.$data['gmt'];

        $datedata = substr($datetime, 1, 25);

        $this->date = new \DateTime($datedata);

        //$this->date = $this->date->format('Y-m-D');
        $this->time = $this->date;
        $this->service = $data['service'];
        $this->requestType = $data['method'];
        $this->path = $data['path'];
        $this->httpHeader = $data['http_header'];
        $this->statusCode = $data['response_code'];

        return true;
    }

    public function saveLogEntry(){

        try 
        {
            $logentry = new LogEntry();
            $logentry->setServiceType($this->service);
            $logentry->setDate($this->date);
            $logentry->setTime($this->time);
            $logentry->setRequestType($this->requestType);
            $logentry->setEndpoint($this->path);
            $logentry->setHttpHeader($this->httpHeader);
            $logentry->setStatusCode($this->statusCode);
            $logentry->setLineNumber($this->lineCount);
            
            
            $this->repository->add($logentry, true);

        } catch (ParserException $exception){
            throw new ParserException('could not save the log entry to the database!');
        }

       
        //$this->entityManager->persist($logentry);
        
        
  
    }

}