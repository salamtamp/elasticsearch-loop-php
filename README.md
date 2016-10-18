# elasticsearch-loop-php
for Looping data from Elasticsearch

#Usage

##Initial setup

1. Install composer. `curl -s http://getcomposer.org/installer | php`

2. Create composer.json containing:
  ```json
  {
      "require" : {
          "salamtam/elasticsearch-loop-php" : "^1.3"
      }
  }
  ```
3. Run `./composer.phar install`

4. Keep up-to-date: `./composer.phar update`

##Example

**Query**
```php
require_once __DIR__ . "/vendor/autoload.php";

use ElasticsearchLoopPHP\ElasticsearchLoop;

/* set connect elasticsearch */
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

$client = new ElasticsearchLoop($host, $user, $pass, $port);
$client->getElasticsearch($params, $callback);
```

