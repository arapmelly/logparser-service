<?php

namespace App\Entity;

use App\Repository\LogDetailRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LogDetailRepository::class)]
class LogDetail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $service;

    #[ORM\Column(type: 'date', nullable: true)]
    private $date;

    #[ORM\Column(type: 'time', nullable: true)]
    private $time;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $requestType;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $httpHeader;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $path;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $statusCode;

    #[ORM\ManyToOne(targetEntity: LogEntry::class, inversedBy: 'logDetails')]
    private $logEntryId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getService(): ?string
    {
        return $this->service;
    }

    public function setService(?string $service): self
    {
        $this->service = $service;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(?\DateTimeInterface $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getRequestType(): ?string
    {
        return $this->requestType;
    }

    public function setRequestType(?string $requestType): self
    {
        $this->requestType = $requestType;

        return $this;
    }

    public function getHttpHeader(): ?string
    {
        return $this->httpHeader;
    }

    public function setHttpHeader(?string $httpHeader): self
    {
        $this->httpHeader = $httpHeader;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(?string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getStatusCode(): ?int
    {
        return $this->statusCode;
    }

    public function setStatusCode(?int $statusCode): self
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    public function getLogEntryId(): ?LogEntry
    {
        return $this->logEntryId;
    }

    public function setLogEntryId(?LogEntry $logEntryId): self
    {
        $this->logEntryId = $logEntryId;

        return $this;
    }
}
