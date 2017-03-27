<?php

namespace ElasticsearchLoopPHP;

use \Elasticsearch\ClientBuilder;
use \Exception;

class ElasticsearchLoop
{
    private $client;

    public function __construct($url, $user=null, $pass=null, $port=null)
    {
        if (is_array($url)) {
            $this->client = $this->createElasticsearchClient($url);
        } else {
            $host = '';
            if (!is_null($user) && !is_null($pass)) {
                $host .= $user . ":" . $pass . "@";
            }

            if (!is_null($port)) {
                $host .= $url . ":" . $port;
            } else {
                $host .= $url;
            }

            $this->client = $this->createElasticsearchClient([$host]);
        }

        return $this;
    }

    private function createElasticsearchClient($host)
    {
        return ClientBuilder::create()->setHosts($host)->build();
    }

    public function getElasticsearch($params, $callback)
    {
        if (empty($params['size'])) {
            $params['size'] = 100;
        }

        if (empty($params['from'])) {
            $params['from'] = 0;
        }

        try {
            $response = $this->client->search($params);
        } catch (Exception $e) {
            exit($e->getMessage() . PHP_EOL);
        }

        $callback($response);

        if (!empty($response['hits']['hits'])) {
            $params['from'] += $params['size'];
            $this->getElasticsearch($params, $callback);
        } else {
            echo "End process" . PHP_EOL;
        }
    }
}
