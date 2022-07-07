<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

use App\Service\LogParserService;

/**
 * 
 * Log parser command
 */
class LogParserCommand extends Command
{
    /**
     * 
     * @var LogParserService
     */
    private $logParserService;


    public function __construct(LogParserService $logParserService)
    {
        $this->logParserService = $logParserService;
        
        parent::__construct();
        
    }

    protected function configure(): void
    {
        $this
            ->setName('app:log-parser')
            ->setDescription('Log parser service: Parses log file and inserts to database')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output ): int
    {
        
        $output->writeln([
            'log file is being processed and inserted into the database',
            '==========================================================',
            '',
        ]);

        $processedLogs = $this->logParserService->processLogFile();
        
        $output->writeln('Processed Lines: '.$processedLogs);
        $output->writeln('Done.');

        return Command::SUCCESS;

    }

}
