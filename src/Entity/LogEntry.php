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
    private $service_type;

    #[ORM\Column(type: 'date', nullable: true)]
    private $date;

    #[ORM\Column(type: 'time', nullable: true)]
    private $time;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $request_type;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $endpoint;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $http_header;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $status_code;

    #[ORM\Column(type: 'bigint', nullable: true)]
    private $line_number;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getServiceType(): ?string
    {
        return $this->service_type;
    }

    public function setServiceType(?string $service_type): self
    {
        $this->service_type = $service_type;

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
        return $this->request_type;
    }

    public function setRequestType(?string $request_type): self
    {
        $this->request_type = $request_type;

        return $this;
    }

    public function getEndpoint(): ?string
    {
        return $this->endpoint;
    }

    public function setEndpoint(?string $endpoint): self
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    public function getHttpHeader(): ?string
    {
        return $this->http_header;
    }

    public function setHttpHeader(?string $http_header): self
    {
        $this->http_header = $http_header;

        return $this;
    }

    public function getStatusCode(): ?string
    {
        return $this->status_code;
    }

    public function setStatusCode(?string $status_code): self
    {
        $this->status_code = $status_code;

        return $this;
    }

    public function getLineNumber(): ?string
    {
        return $this->line_number;
    }

    public function setLineNumber(?string $line_number): self
    {
        $this->line_number = $line_number;

        return $this;
    }
}
