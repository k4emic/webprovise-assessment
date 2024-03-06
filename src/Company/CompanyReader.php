<?php

namespace App\Company;

use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;

/**
 * @phpstan-type CompanyData array{
 *     id: string,
 *     createdAt: string,
 *     name: string,
 *     parentId: string
 * }
 */
class CompanyReader
{
    protected ?PromiseInterface $promise;

    public function __construct(
        protected \GuzzleHttp\ClientInterface $httpClient,
        protected string $dataUri
    )
    {}

    public function fetch(): PromiseInterface
    {
        return $this->promise ?? $this->promise = $this->httpClient->sendAsync(new Request('GET', $this->dataUri));
    }

    /**
     * @return iterable<\App\Company>
     */
    public function all(): iterable
    {
        /** @var ResponseInterface */
        $response = $this->fetch()->wait();

        /** @var array<CompanyData> $companyData */
        $companyData = json_decode($response->getBody(), true);
        $companies = array_map($this->decode(...), $companyData);

        return $companies;
    }

    /**
     * @param CompanyData $data
     */
    protected function decode(array $data): \App\Company
    {
        return new \App\Company(
            $data['id'],
            $data['createdAt'],
            $data['name'],
            $data['parentId'],
        );
    }
}
