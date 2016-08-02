KGPagerBundle
=============

[![Build Status](https://img.shields.io/travis/kgilden/pager-bundle/master.svg?style=flat-square)](https://travis-ci.org/kgilden/pager-bundle)

KGPagerBundle integrates [kgilden/pager](https://github.com/kgilden/pager) with
the Symfony framework.

Usage
-----

By default a single pager is defined. Access it through the `kg_pager` service id.
The current page is inferred from the `page` query parameter.

```php
<?php

use KG\Pager\Adapter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AcmeDemoController extends Controller
{
    public function listPagedAction()
    {
        $qb = $this
            ->getDoctrine()
            ->getRepository('AppBundle:Product')
            ->createQueryBuilder('p')
        ;

        // 25 items per page is used by default.
        $itemsPerPage = 10;
        $page = $this->get('kg_pager')->paginate(Adapter::dql($qb), $itemsPerPage);

        return $this->render('App:Product:listPaged.html.twig', array(
            'page' => $page
        ));
    }
}

?>
```

Of course the pager can also be injected to any service.

```php
<?php

use KG\Pager\Adapter;
use KG\Pager\PagerInterface;

class ExampleService
{
    private $pager;

    public function __construct(PagerInterface $pager)
    {
        $this->pager = $pager;
    }

    public function doSomethingPaged()
    {
        $list = array('foo', 'bar', 'baz');

        return $this->pager->paginate(Adapter::_array($list), 2);
    }
}

?>
```

```xml
<service id="example_service" class="Acme\ExampleService">
    <argument type="service" id="kg_pager" />
</service>
```

Installation
------------

Install using [composer](https://getcomposer.org/download/):

```bash
composer.phar require kgilden/pager-bundle
```

The bundle must then be enabled in the kernel:

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
?>
```

That's it! no extra configuration necessary. You can make sure the bundle's up
and running by executing

```bash
app/console container:debug | grep kg_pager
```

If everything's working, it should print out the pager service.

Configuration
-------------

You may want to optinally configure the bundle to define several pagers, each
with their own settings.

```yaml
kg_pager:
    default: foo              # now `kg_pager` returns a pager named `foo`
    pagers:
        foo:
            per_page: 20      # how many items to have on a single page
            key: custom_page  # the key used to infer the current page i.e. `http://exapmle.com?custom_page=2`
            merge: 10         # if less than 10 items are left on the last page, merge it with the previous page
            redirect: false   # whether to redirect the user, if they requested an out of bounds page
        bar: ~                # pager with default settings
```

The pagers are registered in the service container as `kg_pager.pager.%name%`
with the default pager aliased to `kg_pager`.

You may optionally want to have the default pager be automatically injected to
your entity repositories. For this do the following:

 * Have a custom repository class implement [`PagerAwareInterface`][Doctrine/PagerAwareInterface.php];
 * Set the class as the default repository class and add a custom factory service
   in doctrine configuration:

   ```yml
   // app/config/config.yml
   doctrine:
       orm:
           default_repository_class: 'Repository\Implementing\PagerAwareInterface'
           repository_factory: 'kg_pager.pager_aware_repository_factory'

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

License
-------

This bundle is under the MIT license. See the complete license in the bundle:

    Resources/meta/LICENSE
