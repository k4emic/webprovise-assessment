<?php

namespace App;

use App\Company\CompanyTree;
use App\Travel\TravelReader;

use JsonSerializable;

class CompanyTravelCostReport implements JsonSerializable
{
    public function __construct(
        protected CompanyTree $companyTree,
        protected TravelReader $travelReader,
    )
    {}

    public function jsonSerialize(): mixed
    {
        $data = [];

        foreach ($this->companyTree->getCompaniesFromRootWithDescendants() as $company) {
        }

        /**
         * todo
         * - organize companies into hierarchy/tree
         * - summarize cost
         * - convert data to array for json output
         */

        return $data;
    }
}
