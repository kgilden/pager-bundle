<?php

/*
 * This file is part of the KGPagerBundle package.
 *
 * (c) Kristen Gilden kristen.gilden@gmail.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KG\Bundle\PagerBundle\Test;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;

/**
 * The Doctrine test case is used for running functional tests against an
 * actual database.
 *
 * @author Kristen Gilden <gilden@planet.ee>
 */
class DoctrineTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var resource
     */
    private static $dbHandle;

    /**
     * @var string
     */
    private static $dbPath;

    /**
     * @var EntityManager
     */
    private $em;

    public static function setUpBeforeClass()
    {
        $metadata = stream_get_meta_data(self::$dbHandle = tmpfile());

        self::$dbPath = $metadata['uri'];
    }

    public static function tearDownAfterClass()
    {
        fclose(self::$dbHandle);
    }

    /**
     * @return EntityManager
     */
    protected function getEntityManager()
    {
        if (!$this->em) {
            $em = $this->createEntityManager();

            $tool = new SchemaTool($em);
            $tool->createSchema($this->findClasses($em));

            $this->em = $em;
        }

        return $this->em;
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        $em = $this->getEntityManager();

        $tool = new SchemaTool($em);
        $tool->dropSchema($this->findClasses($em));
    }

    /**
     * @return EntityManager
     */
    private function createEntityManager()
    {
        $em = EntityManager::create(array(
            'driver' => 'pdo_sqlite',
            'path'   => self::$dbPath,
        ), Setup::createAnnotationMetadataConfiguration(array(__DIR__.'/Entity'), true));

        return $em;
    }

    /**
     * @param EntityManager $em
     * @param string|null   $path
     *
     * @return \Doctrine\ORM\Mapping\ClassMetadata[]
     *
     * @throws \RuntimeException if no entities were found in the specified directory
     */
    private function findClasses(EntityManager $em, $path = null)
    {
        $classes = array();

        if (false !== ($filesAndDirs = scandir($path ?: __DIR__.'/Entity'))) {

            foreach ($filesAndDirs as $fileOrDir) {
                if (is_dir($fileOrDir) || '.php' !== substr($fileOrDir, -4)) {
                    continue;  // Skips everything but *.php files.
                }

                $classes[] = $em->getClassMetadata(
                    __NAMESPACE__.'\\Entity\\'.substr($fileOrDir, 0, -4)
                );
            }
        }

        if (!$classes) {
            throw new \RuntimeException('No entities found in `'.__DIR__.'/Entity`.');
        }

        return $classes;
    }
}
