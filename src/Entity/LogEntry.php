<?php

namespace App\Entity;

use App\Repository\LogEntryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\OneToMany(mappedBy: 'logEntryId', targetEntity: LogDetail::class)]
    private $logDetails;

    public function __construct()
    {
        $this->logDetails = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, LogDetail>
     */
    public function getLogDetails(): Collection
    {
        return $this->logDetails;
    }

    public function addLogDetail(LogDetail $logDetail): self
    {
        if (!$this->logDetails->contains($logDetail)) {
            $this->logDetails[] = $logDetail;
            $logDetail->setLogEntryId($this);
        }

        return $this;
    }

    public function removeLogDetail(LogDetail $logDetail): self
    {
        if ($this->logDetails->removeElement($logDetail)) {
            // set the owning side to null (unless already changed)
            if ($logDetail->getLogEntryId() === $this) {
                $logDetail->setLogEntryId(null);
            }
        }

        return $this;
    }
}
