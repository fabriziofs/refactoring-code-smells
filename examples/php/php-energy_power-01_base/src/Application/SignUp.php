<?php

declare(strict_types=1);

namespace CodelyTv\Application;

use CodelyTv\Domain\Contract;
use CodelyTv\Domain\ContractRepository;

final class SignUp
{
    private ContractRepository $repository;

    public function __construct(ContractRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(string $contractId, int $power): void
    {
        Contract::ensurePowerIsNormalized($power);

        $contract = new Contract($contractId, $power);

        $this->repository->save($contract);
    }
}
