<?php

namespace App\Adapter\Infra\ExternalServices\VesselFinder;

use App\Adapter\Infra\ExternalServices\Contracts\Crawler as CrawlerInterface;
use App\Exceptions\ExternalServiceException;
use Exception;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Symfony\Component\DomCrawler\Crawler;
use GuzzleHttp\Client;

class VesselFinderCrawler implements CrawlerInterface
{
    /**
     * @var string
     */
    private const BASE_URL = "https://www.vesselfinder.com/vessels/details/";

    /**
     * @var Client
     */
    private Client $httpClient;

    /**
     * @param Client $httpClient
     */
    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param int $imo
     * @return array
     * @throws Exception
     */
    public function getDetailsByImo(int $imo): array
    {
        $url = self::BASE_URL . $imo;
        try {
            $response = $this->httpClient->get($url);
            $htmlContent = $response->getBody()->getContents();

            $crawler = new Crawler($htmlContent);

            $name = $crawler->filter('h1')->text();
            $flag = $crawler->filter('div.title-flag-icon')->attr('title');
            $dataJson = $crawler->filter('#djson')->attr('data-json');
            $location = json_decode($dataJson, true);

            return [
                'name' => $name,
                'flag' => $flag,
                'latitude' => $location['ship_lat'],
                'longitude' => $location['ship_lon'],
            ];
        }  catch (ClientException | GuzzleException $e) {
            Log::error(
                'error.getDetailsByImo',
                [
                    'message' => $e->getMessage(),
                    'code' => $e->getCode(),
                    'url' => $url,
                ]
            );
            throw new ExternalServiceException('IMO not found!', 404);
        }
    }
}
