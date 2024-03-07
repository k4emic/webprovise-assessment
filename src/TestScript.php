<?php

namespace App;

// phpcs:disable PSR1.Files.SideEffects.FoundWithSymbols

use App\Company\CompanyReader;
use App\Company\CompanyTree;
use App\Travel\TravelReader;
use App\Travel\TravelCalculator;
use GuzzleHttp\Client;

require __DIR__ . '/../vendor/autoload.php';

class TestScript
{
    public function execute(): void
    {
        $start = microtime(true);

        $httpClient = new Client();

        $companyDataUri = 'https://5f27781bf5d27e001612e057.mockapi.io/webprovise/companies';
        $companyReader = new CompanyReader($httpClient, $companyDataUri);

        $travelDataUri = 'https://5f27781bf5d27e001612e057.mockapi.io/webprovise/travels';
        $travelReader = new TravelReader($httpClient, $travelDataUri);

        // start fetching data in parallel for later use
        $companyReader->fetch();
        $travelReader->fetch();

        $report = new CompanyTravelCostReport(
            new CompanyTree($companyReader),
            new TravelCalculator($travelReader)
        );

        echo json_encode($report, JSON_PRETTY_PRINT) . PHP_EOL;
        echo 'Total time: ' .  (microtime(true) - $start) . PHP_EOL;
    }
}

(new TestScript())->execute();
