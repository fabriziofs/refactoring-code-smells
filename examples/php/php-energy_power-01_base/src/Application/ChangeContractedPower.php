<?php

declare(strict_types=1);

namespace CodelyTv\Application;

use CodelyTv\Domain\ContractNotFound;
use CodelyTv\Domain\ContractRepository;

final class ChangeContractedPower
{
    private ContractRepository $repository;

    public function __construct(ContractRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(string $contractId, int $newPower): void
    {
        $contract = $this->repository->search($contractId);
        if (!$contract) {
            throw new ContractNotFound($contractId);
        }

        $contract->changePower($newPower);

        $this->repository->save($contract);
    }
}
