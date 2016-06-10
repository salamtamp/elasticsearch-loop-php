<?php
namespace ElasticsearchLoopPHP;
use Elasticsearch\ClientBuilder;

class ElasticsearchLoop
{
    private $client;

	public function __construct($url, $user, $pass, $port="9200")
	{
        $this->client = $this->createElasticsearchClient([$user . ":" . $pass . "@" .  $url . ":" . $port]);
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
			exit($e->getMessage() . "\n");
		}

		$callback($response);

		if (!empty($response['hits']['hits'])) {
			$params['from'] += $params['size'];
			$this->getElasticsearch($params, $callback);
		} else {
			echo "end process." . "\n";
		}
	}
}

