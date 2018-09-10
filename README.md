# php-prometheus
A PHP client for Prometheus

[![Build Status](https://travis-ci.org/jlis/php-prometheus.svg?branch=master)](https://travis-ci.org/jlis/php-prometheus)
[![StyleCI](https://github.styleci.io/repos/148131239/shield?branch=master)](https://github.styleci.io/repos/148131239)

### Install

Require this package with composer using the following command:

```bash
composer require jlis/php-prometheus
```


### Usage

You create new storage adapters using the adapter factory:

```php
$factory = new \Jlis\PhpPrometheus\Adapter\AdapterFactory();
$adapter = $factory->make('memory');
```

Or you can register new adapters:

```php
$factory = new \Jlis\PhpPrometheus\Adapter\AdapterFactory();
$adapter = $factory->add('redis', new \Jlis\PhpPrometheus\Adapter\RedisAdapter(['host' => 'localhost']));
```

After obtaining an adapter, you may start collecting metrics:

```php
$collector = new \Jlis\PhpPrometheus\Collector\MetricsCollector($adapter);
```

#### Counts

```php
$collector->incrementCount('http_requests_total', 1, ['url' => 'http://foo.bar']);
```

#### Gauge

```php
$collector->updateGauge('current_queue_size', 1337, ['queue' => 'notifications']);
```

#### Histogram

```php
$collector->updateHistogram('some_histogram', 3.5, ['color' => 'blue'], [0.1, 1, 2, 3.5, 4, 5, 6, 7, 8, 9]);
```

### Expose the metrics:

```php
header('Content-Type: ' . \Jlis\PhpPrometheus\Collector\MetricsCollector::MIME_TYPE);

echo $collector->render();
```

## Adapters

The following adapters are available:

* `memory` uses a plain PHP array, only suitable for testing.
* `redis` uses Redis and requires the `ext-redis` PHP extension.
* `apc` uses APCu and requires the `ext-apcu` PHP extensions.

> **Note**: only the `memory` adapter is registered by default. Any other adapter must be registered first.