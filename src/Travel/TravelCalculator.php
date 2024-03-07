<?php

namespace App\Travel;

class TravelCalculator
{
    /**
     * @var array<string, \App\Travel[]>
     */
    protected array $travelsByCompany = [];

    public function __construct(
        protected TravelReader $travelReader,
    ) {
    }

    public function getCostByCompany(string $companyId): int
    {
        return array_reduce(
            $this->getTravelsByCompany($companyId),
            fn(int $carry, \App\Travel $item) => $carry + $item->price,
            0
        );
    }

    /**
     * @return \App\Travel[]
     */
    protected function getTravelsByCompany(string $companyId): array
    {
        if (!$this->travelsByCompany) {
            foreach ($this->travelReader->all() as $travel) {
                $this->travelsByCompany[$travel->companyId][] = $travel;
            }
        }

        return $this->travelsByCompany[$companyId] ?? [];
    }
}
