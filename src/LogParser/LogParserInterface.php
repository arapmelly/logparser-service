<?php

namespace App\LogParser;

use App\LogParser\Exception\ParserException;

/**
 * This is the interface for single log line parser.
 */
interface LogParserInterface
{
    /**
     * Parses single log line.
     *
     * @param string $line
     *
     * @return array
     * @throws ParserException
     */
    public function parseLine($line);
}