<?php

namespace App;

class Company
{
    /**
     * @param iterable<static> $children
     */
    public function __construct(
        public string $id,
        public string $createdAt,
        public string $name,
        public string $parentId,
        public iterable $children = [],
    )
    {}
}
