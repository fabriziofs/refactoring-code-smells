<?php

declare(strict_types=1);

namespace CodelyTv\Application;

use CodelyTv\Domain\Contract;
use CodelyTv\Domain\ContractNotFound;
use CodelyTv\Domain\ContractRepository;
use CodelyTv\Domain\PowerOptimizer;

final class OptimizeContractedPower
{
    private ContractRepository $repository;
    private PowerOptimizer     $optimizer;

    public function __construct(ContractRepository $repository, PowerOptimizer $optimizer)
    {
        $this->repository = $repository;
        $this->optimizer  = $optimizer;
    }

    public function run(string $contractId): void
    {
        $contract = $this->repository->search($contractId);
        if (!$contract) {
            throw new ContractNotFound($contractId);
        }

        $optimizedPower = $this->optimizer->optimize();

        $power = Contract::getNormalizedPower($optimizedPower);

        $contract->changePower($power);

        $this->repository->save($contract);
    }

}
