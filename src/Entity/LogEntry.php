<?php

namespace App\Entity;

use App\Repository\LogEntryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LogEntryRepository::class)]
class LogEntry
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $log_file;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $log_entry;

    #[ORM\Column(type: 'bigint', nullable: true)]
    private $line_number;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogEntry(): ?string
    {
        return $this->log_entry;
    }

    public function setLogEntry(?string $log_entry): self
    {
        $this->log_entry = $log_entry;

        return $this;
    }

    public function getLogFile(): ?string
    {
        return $this->log_file;
    }

    public function setLogFile(?string $log_file): self
    {
        $this->log_file = $log_file;

        return $this;
    }

    public function getLineNumber(): ?int
    {
        return $this->line_number;
    }

    public function setLineNumber(?int $line_number): self
    {
        $this->line_number = $line_number;

        return $this;
    }
}
