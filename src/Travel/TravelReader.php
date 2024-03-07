<?php

namespace App\Travel;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @phpstan-type TravelData array{
 *     id: string,
 *     createdAt: string,
 *     employeeName: string,
 *     departure: string,
 *     destination: string,
 *     price: string,
 *     companyId: string
 * }
 */
class TravelReader
{
    protected ?PromiseInterface $promise;

    public function __construct(
        protected \GuzzleHttp\ClientInterface $httpClient,
        protected string $dataUri
    ) {
    }

    public function fetch(): PromiseInterface
    {
        return $this->promise ?? $this->promise = $this->httpClient->sendAsync(new Request('GET', $this->dataUri));
    }

    /**
     * @return iterable<\App\Travel>
     */
    public function all(): iterable
    {
        /** @var ResponseInterface */
        $response = $this->fetch()->wait();

        /** @var array<TravelData> $companyData */
        $companyData = json_decode($response->getBody(), true);
        $companies = array_map($this->decode(...), $companyData);

        return $companies;
    }

    /**
     * @param TravelData $data
     */
    protected function decode(array $data): \App\Travel
    {
        return new \App\Travel(
            $data['companyId'],
            (int) $data['price'] * 100,
        );
    }
}
