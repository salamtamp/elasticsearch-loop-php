# elasticsearch-loop-php
for Looping data from Elasticsearch

#Usage

##Initial setup

1. Install composer. `curl -s http://getcomposer.org/installer | php`

2. Create composer.json containing:
  ```json
  {
      "require" : {
          "salamtam/elasticsearch-loop-php" : "^1.4"
      }
  }
  ```
3. Run `./composer.phar install`

4. Keep up-to-date: `./composer.phar update`

##Example 1

**Query with URL**
```php
require_once __DIR__ . "/vendor/autoload.php";

use ElasticsearchLoopPHP\ElasticsearchLoop;

/* set connection elasticsearch */
$url = "localhost:9200";

/* set index name and type */
$params = [
    'index' => 'index_name',
    'type' => 'index_type',
    'body' => [
        'query' => [
            'match_all' => []
        ]
    ]
];

/* callback function */
$callback = function($response) {
    foreach ($response as $item) {
  		  print_r($item);
  	}
};

/* set query with url */
$client = new ElasticsearchLoop($url);

$client->getElasticsearch($params, $callback);
```

##Example 2

**Query with basic authentication **
```php
require_once __DIR__ . "/vendor/autoload.php";

use ElasticsearchLoopPHP\ElasticsearchLoop;

/* set connection elasticsearch */
$user = "root";
$pass = "";
$host = "localhost";
$port = "9200";

/* set index name and type */
$params = [
    'index' => 'index_name',
    'type' => 'index_type',
    'body' => [
        'query' => [
            'match_all' => []
        ]
    ]
];

/* callback function */
$callback = function($response) {
    foreach ($response as $item) {
        print_r($item);
    }
};

/* set query with host, user, pass and port */
$client = new ElasticsearchLoop($host, $user, $pass, $port);

$client->getElasticsearch($params, $callback);
```

