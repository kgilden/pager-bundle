<?php

/*
 * This file is part of the KGPagerBundle package.
 *
 * (c) Kristen Gilden kristen.gilden@gmail.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KG\Bundle\PagerBundle\Test\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @author Kristen Gilden <gilden@planet.ee>
 *
 * @Entity
 */
class Entity
{
    /**
     * @var integer
     *
     * @Column(type="integer")
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @OneToMany(targetEntity="Related", mappedBy="entity", cascade={"persist"})
     */
    private $related;

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRelated()
    {
        return $this->related ?: $this->related = new ArrayCollection();
    }
}
