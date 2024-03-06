<?php

namespace App;

class Travel
{
    public function __construct(
        public string $companyId,
        public int $price
    )
    {}
}
