<?php
namespace App\Service;

use App\Entity\LogEntry;
use App\Entity\LogEntryValue;

use App\Repository\LogEntryRepository;
use App\Repository\LogEntryValueRepository;

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

    private $logEntryRepository;

    private $startLine;

   

    public function __construct(LogEntryRepository $repository, LogEntryValueRepository $logEntryRepository) 
    {
        $this->lineCount = 1;
        $this->repository = $repository;
        $this->logEntryRepository = $logEntryRepository;
        $this->logFile = 'logs.txt';
        $this->pattern = '/(?<service>\S+)\s+(?<line_1>\S+)\s+(?<line_2>\S+)\s+(?<datetime>\S+)\s+(?<gmt>\S+)\s+(?<method>\S+)\s+(?<path>\S+)\s+(?<http_header>\S+)\s+(?<response_code>\d+)/';
        $this->resumeProcessing = true;
       
        $this->logParser = new LogParser($this->pattern);
        
       $this->startLine = $this->getStartLine();
        
        
    }

    
    public function processLogFile(){

        

        $logIterator = new LogIterator($this->logFile, $this->logParser, $this->startLine, true);

        foreach( $logIterator as $data){
             
            $currentLine = $logIterator->key();
            $file =  new \SplFileInfo($this->logFile);
            $fileName = $file->getFilename();

            $this->saveLogEntry($fileName, $currentLine, $this->lineCount, $data);
            $this->lineCount++;   
                        
        }

        return $this->lineCount - 1;

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

            $this->saveLogEntryValues($logentry->getId(), $data);

        } catch (ParserException $exception){
            throw new ParserException('could not save the log entry to the database!');
        }        
  
    }


    /**
     * store log entry values in db
     */
    public function saveLogEntryValues($logentryId, $data){

        foreach($data as $key => $value){

            try 
        {
            $logvalue = new LogEntryValue();
            $logvalue->setLogEntryId($logentryId);
            $logvalue->setLogKey($key);
            $logvalue->setLogValue($value);
            
            
            $this->logEntryRepository->add($logvalue, true);

        } catch (ParserException $exception){
            throw new ParserException('could not save the log entry to the database!');
        }   

        }
             
  
    }

}