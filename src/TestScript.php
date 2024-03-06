<?php

namespace App;

use App\Company\CompanyReader;
use App\Company\CompanyTree;
use App\Travel\TravelReader;
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
            $travelReader
        );

        // Enter your code here
        echo json_encode($report);
        echo 'Total time: '.  (microtime(true) - $start) . PHP_EOL;
    }
}

(new TestScript())->execute();
