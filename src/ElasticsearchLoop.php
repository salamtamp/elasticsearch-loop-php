<?php

namespace ElasticsearchLoopPHP;
use Elasticsearch\ClientBuilder;

class ElasticsearchLoop
{
    private $client;

	public function __construct($url, $user=null, $pass=null, $port="9200")
	{
        $host = '';
        if (!is_null($user) && !is_null($pass)) {
            $host .= $user . ":" . $pass . "@";
        }
        $host .= $url . ":" . $port;

        $this->client = $this->createElasticsearchClient([$host]);
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
