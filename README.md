# SphinxSearchBundle
Some SphinxSearch integration with Symfony for `gigablah/sphinxphp` and `foolz/sphinxql-query-builder`.
![Alt text](/doc/images/profiler_error.png?raw=true "Profiler with last error")

### Version 0.1.* was released during [Codewave's shipit day!](http://codewave.eu/shipit-days.html)

# Installation
Install via composer:

```sh
composer require cdwv/sphinx-search-bundle
```

## QueryBuilder

You may register many connections. Example configuration is:

```yml
ekiwok_sphinx:
    connections:
        default:
            host: localhost
            port: 9306
            driver: pdo
        remote:
            host: remote-host
            port: 9306
            driver: mysqli
```

Default connection with following configuration will always be created unless you provide alternative default configuration:

```yml
host: localhost
port: 9306
driver: pdo
```

It means if you want to use pdo and you are running sphinx daemon on localhost on port 9306 you do not have to provide any configuration.

Please notice that `$this->get('sphinx')->getConnection()` is equivalent to `$this->get('sphinx')->getConnection('default')`.

Connections returned by `sphinx` service implements `Ekiwok\SphinxBundle\Sphinx\QL\ConnectionInterface` that extends `Foolz\SphinxQL\Drivers\ConnectionInterface` by `createQueryBuilder()` method so thay may be (and shoud be) used interchangeable with Foolz\SphinxQL connections.

Examples of usage:

```yml
$sphinx = $this->get('sphinx');
$conn = $sphinx->getConnection();
$recipes = $conn->createQueryBuilder()
                ->select('id', 'title')
                ->from('recipes')
                ->match('title', 'chicken')
                ->limit(100)
                ->execute();
```

```php
$sphinx = $this->get('sphinx');
$conn = $sphinx->getConnection();
$recipes = $conn->query('SELECT id, title FROM recipes WHERE MATCH("(@title chicken)")');
```

For more please visit [https://github.com/FoolCode/SphinxQL-Query-Builder](https://github.com/FoolCode/SphinxQL-Query-Builder)

## gigablah/sphinxphp

### Fresh use
If you are just starting using sphinx in your project all you have to do is declare your default connection:

```
    sphinx.default.connection:
        class: Sphinx\SphinxClient
        calls: 
            - [setServer, ['127.0.0.1', 9312] ]
```

Next decorate it with data collector:

```
    sphinx.default:
        class: Ekiwok\SphinxBundle\Sphinx\SphinxDataCollector
        arguments: [@sphinx.default.connection, @sphinx_stats]
```

`@sphinx_stats` is service that provides data to profiler. You may implement your own provider by implementing: `Ekiwok\SphinxBundle\Sphinx\SphinxDataCollector`

Now use `sphinx.default` like `Sphinx\SphinxClient`.

` $sphinxClient = $this->get('sphinx.default'); `

### Replacing Sphinx\SphinxClient

#### Symfony 2.5+

If you are using Symfony 2.5+ you may be interested in service decoration: http://symfony.com/doc/current/components/dependency_injection/advanced.html#decorating-services

#### Replacing Sphinx\SphinxClient

If you have your SphinxClient registered for example as `sphinx.default` use little hack, change this service name to `sphinx.default.connection`
and register SphinxDataCollector as `sphinx.default`. Because SphinxDataCollector extends SphinxClient it shoud have no side effects on your project:

```
    sphinx.default:
        class: Ekiwok\SphinxBundle\Sphinx\SphinxDataCollector
        arguments: [@sphinx.default.connection, @sphinx_stats]
```

You can always instantiate SphinxDataCollector manually (for example in situation when you don't have your SphinxClient managed by container)

```
    // $sphinxClient is instance of Sphinx\SphinxClient
    $sphinxStats = $this->get('sphinx_stats');
    $sphinxClient = new \Ekiwok\SphinxBundle\Sphinx\SphinxDataCollector($sphinxClient, $sphinxStats);
```

# What does this bundle do?

Well, it shows fancy things and stuff in profiler and toolbar. Those things are now query calls and errors. So all it does is tracking calls of SphinxClient query method and measuring time of this method execution (yeah, it's not actuall query time).

Because SphinxClient uses binary protocol this bundle does not show real human readable queries that may be copied to sphinx cli. (Now =) Unfortunately, it shows just arguments (query, indexes and comment) passed to query method.

This bundle tracks all errors that unfold during executing queries.

# Authors
This bundle was originally developed by [Piotr Kowalczyk](https://github.com/ekiwok) 

