<?php

declare(strict_types=1);

namespace CodelyTv\Domain;

final class Contract
{
    public const NORMALIZED_POWERS = [
        1150,
        1725,
        2300,
        3450,
        4600,
        5750,
        6900,
        8050,
        9200
    ];
    private string $id;
    private int    $contractedPower;

    public function __construct(string $id, int $contractedPower)
    {
        $this->ensurePowerIsNormalized($contractedPower);

        $this->id              = $id;
        $this->contractedPower = $contractedPower;
    }

    private function ensurePowerIsNormalized(int $newPower): void
    {
        if (!in_array($newPower, self::NORMALIZED_POWERS)) {
            throw new InvalidPower($newPower);
        }
    }

    public function changePower(int $selectedPower): void
    {
        $this->ensurePowerIsNormalized($selectedPower);

        $this->contractedPower = $selectedPower;
    }

    public function power(): int
    {
        return $this->contractedPower;
    }

    public function id(): string
    {
        return $this->id;
    }
}
