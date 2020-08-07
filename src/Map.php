<?php
namespace Dongdavid\AmapMapSdk;

use dongdavid\AmapMapSdk\Exceptions\HttpException;
use dongdavid\AmapMapSdk\Exceptions\InvalidArgumentException;
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
        $url = 'https://restapi.amap.com/v3/ip?parameters';

        if (!\in_array(\strtolower($formate), ['json', 'xml'])) {
            throw new InvalidArgumentException("Invalid response formate: " . $formate);
        }

        $query = array_filter([
            'key'    => $this->key,
            'ip'     => $ip,
            'output' => $formate,
            // 'sig' => '',
        ]);
        try {
            $response = $this->getHttpClient()
                ->get($url, ['query' => $query])
                ->getBody()
                ->getContents();
            return 'json' === $formate ? \json_decode($response, true) : $response;
        } catch (\Exception $e) {
            throw new HttpException($e->getMessage(), $e->getCode(), $e);
        }

    }

    public function geocode(string $address, string $city = '', bool $batch = false, string $formate = 'json')
    {
        $url = 'https://restapi.amap.com/v3/geocode/geo?parameters';

        if (!\in_array(\strtolower($formate), ['json', 'xml'])) {
            throw new InvalidArgumentException("Invalid response extensions: " . $formate);
        }

        $query = array_filter([
            'key'     => $this->key,
            'address' => $address,
            'city'    => $city,
            'batch'   => $batch,
            'output'  => $formate,
            // 'sig' => '',
        ]);

        try {
            $response = $this->getHttpClient()
                ->get($url, ['query' => $query])
                ->getBody()
                ->getContents();
            return 'json' === $formate ? \json_decode($response, true) : $response;
        } catch (\Exception $e) {
            throw new HttpException($e->getMessage(), $e->getCode(), $e);
        }

    }

    public function regeocode(
        string $location,
        int $radius = 1000,
        string $extensions = 'all',
        int $roadlevel = 0,
        bool $batch = false,
        string $poitype = '',
        string $formate = 'json') {
        $url = 'https://restapi.amap.com/v3/geocode/regeo?parameters';

        if (!\in_array(\strtolower($extensions), ['base', 'all'])) {
            throw new InvalidArgumentException("Invalid params extensions: " . $extensions);
        }

        if (!\in_array(\strtolower($roadlevel), [0, 1])) {
            throw new InvalidArgumentException("Invalid params roadlevel: " . $roadlevel);
        }

        if (!\in_array(\strtolower($formate), ['json', 'xml'])) {
            throw new InvalidArgumentException("Invalid response formate: " . $formate);
        }

        $query = array_filter([
            'key'        => $this->key,
            'location'   => $location,
            'radius'     => $radius,
            'extensions' => $extensions,
            'roadlevel'  => $roadlevel,
            // 'poitype'     => $poitype,
            // 'homeorcorp'     => $homeorcorp,
            'batch'      => $batch,
            'output'     => $formate,
            // 'sig' => '',
        ], function ($val) {
            return $val !== null;
        });
        try {
            $response = $this->getHttpClient()
                ->get($url, ['query' => $query])
                ->getBody()
                ->getContents();
            return 'json' === $formate ? \json_decode($response, true) : $response;
        } catch (\Exception $e) {
            throw new HttpException($e->getMessage(), $e->getCode(), $e);
        }

    }

    public function directionWalk(string $origin, string $destination, string $formate = 'json')
    {
        $url = 'https://restapi.amap.com/v3/direction/walking?parameters';

        if (!\in_array(\strtolower($formate), ['json', 'xml'])) {
            throw new InvalidArgumentException("Invalid response formate: " . $formate);
        }

        $query = array_filter([
            'key'         => $this->key,
            'origin'      => $origin,
            'destination' => $destination,
            'output'      => $formate,
            // 'sig' => '',
        ]);
        try {
            $response = $this->getHttpClient()
                ->get($url, ['query' => $query])
                ->getBody()
                ->getContents();
            return 'json' === $formate ? \json_decode($response, true) : $response;
        } catch (\Exception $e) {
            throw new HttpException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function directionTransit(
        string $origin,
        string $destination,
        string $city,
        string $cityd = '',
        int $strategy = 0,
        string $extensions = 'all',
        int $nightflag = 0,
        string $date = null,
        string $time = null,
        string $formate = 'json') {
        $url = 'https://restapi.amap.com/v3/direction/transit/integrated?parameters';

        if (!\in_array(\strtolower($extensions), ['base', 'all'])) {
            throw new InvalidArgumentException("Invalid params extensions: " . $extensions);
        }

        if (!\in_array($strategy, [0, 1, 2, 3, 5])) {
            throw new InvalidArgumentException("Invalid params strategy: " . $strategy);
        }

        if (!\in_array($nightflag, [0, 1])) {
            throw new InvalidArgumentException("Invalid params nightflag: " . $nightflag);
        }

        if (!\in_array(\strtolower($formate), ['json', 'xml'])) {
            throw new InvalidArgumentException("Invalid response formate: " . $formate);
        }

        $query = array_filter([
            'key'         => $this->key,
            'origin'      => $origin,
            'destination' => $destination,
            'city'        => $city,
            'cityd'       => $cityd,
            'extensions'  => $extensions,
            'strategy'    => $strategy,
            'nightflag'   => $nightflag,
            'date'        => $date,
            'time'        => $time,
            'output'      => $formate,
            // 'sig' => '',
        ], function ($val) {
            return $val !== null;
        });
        try {
            $response = $this->getHttpClient()
                ->get($url, ['query' => $query])
                ->getBody()
                ->getContents();
            return 'json' === $formate ? \json_decode($response, true) : $response;
        } catch (\Exception $e) {
            throw new HttpException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function directionDriving(
        string $origin,
        string $destination,
        int $strategy = 10,
        string $extensions = 'all',
        int $cartype = 0,
        string $formate = 'json') {
        $url = 'https://restapi.amap.com/v3/direction/driving?parameters';

        if (!\in_array(\strtolower($extensions), ['base', 'all'])) {
            throw new InvalidArgumentException("Invalid params extensions: " . $extensions);
        }

        if ($strategy < 0 || $strategy > 20) {
            throw new InvalidArgumentException("Invalid params strategy: " . $strategy);
        }

        if (!\in_array($cartype, [0, 1, 3])) {
            throw new InvalidArgumentException("Invalid params cartype: " . $cartype);
        }

        if (!\in_array(\strtolower($formate), ['json', 'xml'])) {
            throw new InvalidArgumentException("Invalid response formate: " . $formate);
        }

        $query = array_filter([
            'key'         => $this->key,
            'origin'      => $origin,
            'destination' => $destination,
            'extensions'  => $extensions,
            'strategy'    => $strategy,
            'cartype'     => $cartype,
            'output'      => $formate,
            // 'originid'=>'',
            // 'origintype'=>'',
            // 'destinationid'=>'',
            // 'destinationtype'=>'',
            // 'waypoints'=>'',
            // 'avoidpolygons'=>'',
            // 'avoidroad'=>'',
            // 'province'=>'',
            // 'number'=>'',
            // 'ferry'=>0,
            // 'roadaggregation'=>false,
            // 'nosteps'=>0,
            // 'sig' => '',
        ], function ($val) {
            return $val !== null;
        });
        try {
            $response = $this->getHttpClient()
                ->get($url, ['query' => $query])
                ->getBody()
                ->getContents();
            return 'json' === $formate ? \json_decode($response, true) : $response;
        } catch (\Exception $e) {
            throw new HttpException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function directionBicycling(string $origin, string $destination, string $formate = 'json')
    {
        $url = 'https://restapi.amap.com/v4/direction/bicycling?parameters';

        if (!\in_array(\strtolower($formate), ['json', 'xml'])) {
            throw new InvalidArgumentException("Invalid response formate: " . $formate);
        }

        $query = array_filter([
            'key'         => $this->key,
            'origin'      => $origin,
            'destination' => $destination,
            'output'      => $formate,
            // 'sig' => '',
        ]);
        try {
            $response = $this->getHttpClient()
                ->get($url, ['query' => $query])
                ->getBody()
                ->getContents();
            return 'json' === $formate ? \json_decode($response, true) : $response;
        } catch (\Exception $e) {
            throw new HttpException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function directionTruck(
        string $origin,
        string $destination,
        int $strategy = 10,
        int $size = 1,
        int $cartype = 0,
        string $formate = 'json') {
        $url = 'https://restapi.amap.com/v4/direction/truck?parameters';

        if (!\in_array($size, [1, 2, 3, 4])) {
            throw new InvalidArgumentException("Invalid params size: " . $size);
        }

        if ($strategy < 0 || $strategy > 20) {
            throw new InvalidArgumentException("Invalid params strategy: " . $strategy);
        }

        if (!\in_array($cartype, [0, 1, 3])) {
            throw new InvalidArgumentException("Invalid params cartype: " . $cartype);
        }

        if (!\in_array(\strtolower($formate), ['json', 'xml'])) {
            throw new InvalidArgumentException("Invalid response formate: " . $formate);
        }

        $query = array_filter([
            'key'         => $this->key,
            'origin'      => $origin,
            'destination' => $destination,
            'size'        => $size,
            'strategy'    => $strategy,
            'cartype'     => $cartype,
            'output'      => $formate,
            // 'originid'=>'',
            // 'origintype'=>'',
            // 'destinationid'=>'',
            // 'destinationtype'=>'',
            // 'waypoints'=>'',
            // 'avoidpolygons'=>'',
            // 'avoidroad'=>'',
            // 'province'=>'',
            // 'number'=>'',
            // 'ferry'=>0,
            // 'roadaggregation'=>false,
            // 'nosteps'=>0,
            // 'sig' => '',
        ], function ($val) {
            return $val !== null;
        });
        try {
            $response = $this->getHttpClient()
                ->get($url, ['query' => $query])
                ->getBody()
                ->getContents();
            return 'json' === $formate ? \json_decode($response, true) : $response;
        } catch (\Exception $e) {
            throw new HttpException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function distance(
        string $origins,
        string $destination,
        int $type = 0,
        string $formate = 'json') {
        $url = 'https://restapi.amap.com/v3/distance?parameters';

        if (!\in_array($type, [0, 1, 3])) {
            throw new InvalidArgumentException("Invalid params type: " . $type);
        }

        if (!\in_array(\strtolower($formate), ['json', 'xml'])) {
            throw new InvalidArgumentException("Invalid response formate: " . $formate);
        }

        $query = array_filter([
            'key'         => $this->key,
            'origins'      => $origins,
            'destination' => $destination,
            'type'        => $type,
            // 'sig' => '',
        ], function ($val) {
            return $val !== null;
        });
        try {
            $response = $this->getHttpClient()
                ->get($url, ['query' => $query])
                ->getBody()
                ->getContents();
            return 'json' === $formate ? \json_decode($response, true) : $response;
        } catch (\Exception $e) {
            throw new HttpException($e->getMessage(), $e->getCode(), $e);
        }
    }

}