<?php



namespace App\LogParser;

/**
 * Log parser implementation which use regular expression to parse line.
 * 
 */

class LogParser extends AbstractLogParser
{
    /**
     * @var string
     */
    private $pattern;

    /**
     * Constructor.
     *
     * @param string $pattern
     */
    public function __construct($pattern)
    {
        $this->pattern = $pattern;
    }

    /**
     * {@inheritdoc}
     */
    protected function getPattern()
    {
        
        return $this->pattern;
    }
}