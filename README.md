# SphinxSearchBundle
Some SphinxSearch integration with Symfony. Already done:
* symfony profiler integration
  * number of query calls
  * time of query calls
  * counting and displaying errors
![Alt text](/doc/images/profiler_error.png?raw=true "Profiler with last error")

# Installation
Install via composer:

` composer require ekiwok/sphinxbundle `

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

This bundle trakcs all errors that unfold during executing queries.

# What this bundle should do?

This bundle should provide much better integration with Symfony by providing:
* tracking queries execution
* tracking sphinx errors
* automatisation of sphinx.conf generation
* bridge between doctrine query builder and indexes configuration
