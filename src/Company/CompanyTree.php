<?php

namespace App\Company;

use App\Company\CompanyReader;

class CompanyTree
{
    public function __construct(
        protected CompanyReader $companyReader
    ) {
    }

    /**
     * @return \App\Company[]
     */
    public function getCompaniesFromRootWithDescendants(): array
    {
        $companies = $this->companyReader->all();

        /** @var array<string|int, \App\Company> */
        $byParentId = [];
        foreach ($companies as $company) {
            // ingest references already in place
            $company->children = new \ArrayObject($byParentId[$company->id] ?? []);
            $byParentId[$company->id] = $company->children; // replace array with internal list
            $byParentId[$company->parentId][] = $company; // assign to own parent
        }

        return $byParentId['0'] ?? [];
    }

    protected function depthFirstTraversal(\App\Company $company): \Generator
    {
        foreach ($company->children as $child) {
            yield from $this->depthFirstTraversal($child);
        }

        yield $company;
    }

    public function foo(): string
    {
        return '';
    }

    /**
     * @return \App\Company[]
     */
    public function descendants(\App\Company $company): array
    {
        /** @var \App\Company[] */
        $descendants = [];
        foreach ($this->depthFirstTraversal($company) as $descendant) {
            $descendants[] = $descendant;
        }

        array_pop($descendants); // remove self
        return $descendants;
    }
}
