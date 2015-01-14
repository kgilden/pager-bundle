KGPagerBundle
=============

[![Build Status](https://img.shields.io/travis/kgilden/pager-bundle/master.svg?style=flat)](https://travis-ci.org/kgilden/pager-bundle)

KGPagerBundle is a simple bundle to paginate iterable elements. Out of the box
the bundle is able to page the following:

*   Doctrine DQL queries;
*   SQL in the form of a Doctrine's DBAL QueryBuilder object;
*   arrays;

The project grew out of necessity to have a simple yet flexible paging
solution, that would be very easy to bolt on.

Usage
-----

Let's say a bunch of Doctrine entities are required to be paged. Simply inject
the generic pager inside a custom repository.

```php
<?php
namespace Acme\Bundle\DemoBundle\Repository;

use Doctrine\ORM\EntityRepository;
use KG\Bundle\PagerBundle\Pager\PagerInterface;

class FooRepository extends EntityRepository
{
    public function setPager(PagerInterface $pager)
    {
        $this->pager = $pager;
    }

    /**
     * Finds all `foo` elements and pages them. This is obviously a very
     * simple use case for the sake of brevity.
     *
     * @return KG\Bundle\PagerBundle\Result\PageInterface
     */
    public function findAllPaged()
    {
        $qb = $this->createQueryBuilder('foo');

        return $this->pager->paginate($qb);
    }
}
```

The returned `PageInterface` object is at this point not yet populated with
the elements. For this to actually happen, the page needs two more pieces
of information: the current page and the amount of elements to be displayed
per page. The corresponding controller action would probably look something
along the lines of the following:

```php
<?php
// src/Acme/Bundle/AcmeDemoBundle/Controller/FooController.php

public function listFoosAction()
{
    // `$foos` can be iterated over like any other array
    $foos = $this
        ->get('doctrine')
        ->getRepository('AcmeDemoBundle:Foo')
        ->findAllPaged()
    ;
    $foos->setElementsPerPage(25);
    $foos->setCurrentPage(2);

    return $this->render('AcmeDemoBundle:Foo:list.html', array(
        'foos' => $foos,
    ));
}
```

As seen from the previous example, you can decide for yourself when exactly
is it the right time to set the current page and elements per page. It's
even possible to set the current page and elements per page in a template.

Installation
------------

Add KGPagerBundle in your `composer.json`:

```json
{
    "require": {
        "kgilden/pager-bundle": "~1.0"
    }
}
```

Update the dependencies:

    composer update kgilden/pager-bundle

Finally enable the bundle by appending it to `app/AppKernel.php`:

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new KG\Bundle\PagerBundle\KGPagerBundle(),
    );
}
```

Contributing
------------

If you think the bundle could be improved (which I'm 100% sure it can be),
simply make a pull request or write an issue. Please try to follow the PSR
coding style when contributing. Thanks!

Testing
-------

Simply run `phpunit` in the root directory of the bundle to run the full
test suite.

Unit tests can be run using `phpunit --testsuite "Unit Tests"`, functional
tests by using `phpunit --testsuite "Functional Tests"`.

License
-------

This bundle is under the MIT license. See the complete license in the bundle:

    Resources/meta/LICENSE
