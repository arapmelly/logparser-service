<?php
namespace App\Service;

use App\Entity\LogEntry;
use App\Entity\LogDetail;

use App\Repository\LogEntryRepository;
use App\Repository\LogDetailRepository;

use App\LogParser\LogIterator;
use App\LogParser\LogParser;

use App\LogParser\Exception\ParserException;


/**
 * This is the class that loads logfile, parse log file and insert parsed data to database
 */

class LogParserService {

    

    private $pattern;

    private $logParser;

    private $logFile;

    private $lineCount;

    private $repository;

    private $logDetailRepository;

    private $startLine;

   

    public function __construct(LogEntryRepository $repository, LogDetailRepository $logDetailRepository) 
    {
        $this->lineCount = 1;
        $this->repository = $repository;
        $this->logDetailRepository = $logDetailRepository;
        $this->logFile = 'logs.txt';
        
        $this->pattern = '/(?<service>\S+) (?<space1>\S+) (?<spacer2>\S+) (?<datetime>\[([^:]+):(\d+:\d+:\d+) ([^\]]+)\]) (?<requestType>\S+) (?<path>\S+) (?<httpHeader>\S+) (?<status>\d+)/';
        
        $this->logParser = new LogParser($this->pattern);
        
       $this->startLine = $this->getStartLine();
        
        
    }

    
    public function processLogFile(){

        

        $logIterator = new LogIterator($this->logFile, $this->logParser, $this->startLine, true);

        foreach( $logIterator as $data){

            $data = $this->processData($data);

           // dd($data);
             
            $currentLine = $logIterator->key();
            $file =  new \SplFileInfo($this->logFile);
            $fileName = $file->getFilename();

            $this->saveLogEntry($fileName, $currentLine, $this->lineCount, $data);
            $this->lineCount++;   
                        
        }

        return $this->lineCount - 1;

    }

    /**
     * process log data
     */
    private function processData($data){

        
        foreach($data as $key => $value){
            //check for datetime, httpHeader, path process these by removing special characters if present.
            if($key === 'datetime'){

                $data['date'] =  $this->processDateTime($value, 'date');
                $data['time'] =  $this->processDateTime($value, 'time');

            } 
            
            /**
             * process request type by removing double quotes (")
             */
            if($key === 'requestType'){

                $data[$key] = preg_replace("/[\"\']/", "", $value );  
            } 

            /**
             * 
             * process http header by removing double quotes (")
             */
            if($key === 'httpHeader'){

                $data[$key] = preg_replace("/[\"\']/", "", $value );  
            } 

            /**
             * process path by removing (/)
             */
            if($key === 'path'){
                 
                $data[$key] = preg_replace("/[\/\']/", "", $value );  
            } 

            

        }

       

        return $data;

        
    }


    /**
     * process datetime entry
     */
    private function processDateTime($value, $key){

        //remove parantheses
        $date = preg_replace("/[\[\']/", "", $value ); 
        $date = preg_replace("/[\]\']/", "", $date );

        
        $dt = new \DateTime($date);

        //separate date and time based on key
        if($key === 'date'){
            $val = $dt->format('m/d/Y');
        }

        if($key === 'time'){
            $val = $dt->format('H:i:s');
        }
       
        return $val;

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

    

    public function saveLogEntry($fileName, $currentLine, $lineCount, $data){

        try 
        {
            $logentry = new LogEntry();
            $logentry->setLogFile($fileName);
            $logentry->setLogEntry($currentLine);
            $logentry->setLineNumber($lineCount);
            
            
            $this->repository->add($logentry, true);

            $this->saveLogEntryValues($logentry, $data);

        } catch (ParserException $exception){
            throw new ParserException('could not save the log entry to the database!');
        }        
  
    }


    /**
     * store log entry values in db
     */
    public function saveLogEntryValues($logentryId, $data){

     
        try 
        {
            $logvalue = new LogDetail();
            $logvalue->setLogEntryId($logentryId);
            $logvalue->setService($data['service']);
            $logvalue->setDate(new \DateTime($data['date']));
            $logvalue->setTime(new \DateTime($data['time']));
            $logvalue->setRequestType($data['requestType']);
            $logvalue->setPath($data['path']);
            $logvalue->setHttpHeader($data['httpHeader']);
            $logvalue->setStatusCode($data['status']);
            
            
            $this->logDetailRepository->add($logvalue, true);

        } catch (ParserException $exception){
            throw new ParserException('could not save the log entry to the database!');
        }   
    }


    /**
     * get logs count
     */
    public function getLogCount($requestParam){


       $result = $this->logDetailRepository->logCount($requestParam);


       foreach($result as $r){
       
            $response['counter'] = $r['total'];
       }
       
       return $response;
    }

}