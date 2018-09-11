# php-prometheus
A PHP client for Prometheus

[![Build Status](https://travis-ci.org/jlis/php-prometheus.svg?branch=master)](https://travis-ci.org/jlis/php-prometheus)
[![StyleCI](https://github.styleci.io/repos/148131239/shield?branch=master)](https://github.styleci.io/repos/148131239)

## Install

Require this package with composer using the following command:

```bash
composer require jlis/php-prometheus
```


## Usage

First create an adapter:

```php
$adapter = new \Jlis\PhpPrometheus\Adapter\RedisAdapter(['host' => 'localhost']);
```

Next, you may pass it to the collector and start collecting metrics:

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

#### Expose the metrics

```php
header('Content-Type: ' . \Jlis\PhpPrometheus\Collector\MetricsCollector::MIME_TYPE);

echo $collector->render();
```

> **Note:** Be sure to set the correct content type for Prometheus.

## Adapters

The following adapters are available:

* `\Jlis\PhpPrometheus\Adapter\InMemoryAdapter` uses a plain PHP array, only suitable for testing.
* `\Jlis\PhpPrometheus\Adapter\RedisAdapter` uses Redis and requires the `ext-redis` PHP extension.
* `\Jlis\PhpPrometheus\Adapter\ApcuAdapter` uses APCu and requires the `ext-apcu` PHP extension.

You can easily create your own storage adapter by extending the `\Jlis\PhpPrometheus\Adapter\AbstractAdapter` class.