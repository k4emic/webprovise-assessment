<?php

namespace App;

use App\Company\CompanyTree;
use App\Travel\TravelCalculator;
use JsonSerializable;

class CompanyTravelCostReport implements JsonSerializable
{
    public function __construct(
        protected CompanyTree $companyTree,
        protected TravelCalculator $travelCalculator,
    ) {
    }

    public function jsonSerialize(): mixed
    {
        $data = [];

        foreach ($this->companyTree->getCompaniesFromRootWithDescendants() as $company) {
            $data[] = $this->buildCompanyReport($company);
        }

        return $data;
    }

    protected function buildCompanyReport(\App\Company $company): mixed
    {
        $report = [
            'id' => $company->id,
            'createdAt' => $company->createdAt,
            'name' => $company->name,
            'parentId' => $company->parentId,
        ];

        $cost = $this->travelCalculator->getCostByCompany($company->id);

        foreach ($this->companyTree->descendants($company) as $descendant) {
            $cost += $this->travelCalculator->getCostByCompany($descendant->id);
        }

        $report['cost'] = $cost;

        foreach ($company->children as $child) {
            $report['children'][] = $this->buildCompanyReport($child);
        }

        return $report;
    }
}
