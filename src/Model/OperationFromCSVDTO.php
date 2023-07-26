<?php

namespace App\Model;

use DateTime;

class OperationFromCSVDTO
{

    public ?string $symbol = null;

    public ?int $position = null;

    public ?string $type = null;

    public ?float $lots = null;

    public ?\DateTimeInterface $openTime = null;

    public ?float $openPrice = null;

    public ?\DateTimeInterface $closeTime = null;

    public ?float $closePrice = null;

    public ?float $profit = null;
    public ?float $netProfit = null;
    public function __construct(
        array $row
    ){
        $this->symbol = $row[0] ?? null;
        $this->position= intval($row[1]) ?? null;
        $this->type=$row[2] ?? null;
        $this->lots=floatval($row[3]) ?? null;
        $this->openTime=DateTime::createFromFormat('d.m.Y H:i:s', $row[4]) ?? null;
        $this->openPrice=floatval($row[5]) ?? null;
        $this->closeTime=DateTime::createFromFormat('d.m.Y H:i:s', $row[6]) ?? null;
        $this->closePrice=floatval($row[7]) ?? null;
        $this->profit=floatval($row[8]);
        $this->netProfit=floatval($row[9]) ?? null;
    }


}
