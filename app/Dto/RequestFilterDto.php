<?php

namespace App\Dto;

use Carbon\Carbon;

class RequestFilterDto
{
    public function __construct(
        protected ?string $status,
        protected ?Carbon $dateFrom,
        protected ?Carbon $dateTo,
    )
    {
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function getDateTo(): ?Carbon
    {
        return $this->dateTo;
    }

    public function getDateFrom(): ?Carbon
    {
        return $this->dateFrom;
    }
}
