<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Service\LogParserService;

class LogServiceTest extends KernelTestCase
{
    public function testProcessLog(): void
    {
        $kernel = self::bootKernel();

        $this->assertSame('test', $kernel->getEnvironment());
        
        $logParserService = static::getContainer()->get(LogParserService::class);
        $status = $logParserService->processLogFile();
        $this->assertTrue($status);
    }
}
