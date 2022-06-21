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

        $power = $this->getNormalizedPower($optimizedPower);

        $contract->changePower($power);

        $this->repository->save($contract);
    }

    private function getNormalizedPower(int $optimizedPower): int
    {
        foreach (Contract::NORMALIZED_POWERS as $NORMALIZED_POWER) {
            if ($optimizedPower <= $NORMALIZED_POWER) {
                return $NORMALIZED_POWER;
            }
        }
        return Contract::NORMALIZED_POWERS[array_key_last(Contract::NORMALIZED_POWERS)];
    }
}
