<?php
namespace Dongdavid\AmapMapSdk;

use GuzzleHttp\Client;

/**
 *
 */
class Map
{
    protected $key;
    protected $guzzleOptions = [];

    public function __construct(string $key)
    {
        $this->key = $key;
    }

    public function getHttpClient()
    {
        return new Client($this->guzzleOptions);
    }


    public function setGuzzleOptions(array $options)
    {
        $this->guzzleOptions = $options;
    }

    public function getLocation($ip, string $formate = 'json')
        {
            $url = 'https://restapi.amap.com/v3/weather/weatherInfo';
            $url = 'https://restapi.amap.com/v3/ip?parameters';

            if (!\in_array(\strtolower($formate), ['json','xml'])) {
                throw new InvalidArgumentException("Invalid response formate: ".$formate);
            }

            $query = array_filter([
                'key' => $this->key,
                'ip' => $ip,
                'output' => $formate,
                // 'sig' => '',
            ]);
            try {
                $response = $this->getHttpClient()
                                    ->get($url,['query'=>$query])
                                    ->getBody()
                                    ->getContents();
                return 'json' === $formate ? \json_decode($response, true) : $response;
            } catch (\Exception $e) {
                throw new HttpException($e->getMessage(), $e->getCode(), $e);
            }


        }
}