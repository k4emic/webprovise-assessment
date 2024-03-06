<?php

namespace App\Company;

use App\Company\CompanyReader;
use Iterator;

class CompanyTree
{
    public function __construct(
        protected CompanyReader $companyReader
    )
    {}

    /**
     * @return iterable<\App\Company>
     */
    public function getCompaniesFromRootWithDescendants(): iterable
    {
        $companies = $this->companyReader->all();

        $byParentId = [];
        foreach ($companies as $company) {
            $company->children = new \ArrayObject($byParentId[$company->id] ?? []); // ingest references already in place
            $byParentId[$company->id] = $company->children; // replace array with internal list
            $byParentId[$company->parentId][] = $company; // assign to own parent
        }

        return $companies;
    }

    public function getDepthFirstIterator(): Iterator
    {

    }
}
