<?php

namespace App\Entity;

use App\Repository\LogEntryValueRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LogEntryValueRepository::class)]
class LogEntryValue
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $logEntryId;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $logKey;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $logValue;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogEntryId(): ?int
    {
        return $this->logEntryId;
    }

    public function setLogEntryId(int $logEntryId): self
    {
        $this->logEntryId = $logEntryId;

        return $this;
    }

    public function getLogKey(): ?string
    {
        return $this->logKey;
    }

    public function setLogKey(?string $logKey): self
    {
        $this->logKey = $logKey;

        return $this;
    }

    public function getLogValue(): ?string
    {
        return $this->logValue;
    }

    public function setLogValue(?string $logValue): self
    {
        $this->logValue = $logValue;

        return $this;
    }

}
