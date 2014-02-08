<?php

/*
 * This file is part of the KGPagerBundle package.
 *
 * (c) Kristen Gilden kristen.gilden@gmail.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KG\Bundle\PagerBUndle\Test\Entity;

use KG\Bundle\PagerBundle\Test\Entity\Entity;

/**
 * @author Kristen Gilden <gilden@planet.ee>
 *
 * @Entity
 */
class Related
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
     * @var Entity
     *
     * @ManyToOne(targetEntity="Entity", inversedBy="related")
     */
    private $entity;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param Entity|null $entity
     */
    public function setEntity(Entity $entity = null)
    {
        $this->entity = $entity;

        $entity->getRelated()->add($this);
    }

    /**
     * @return Entity
     */
    public function getEntity()
    {
        return $this->entity;
    }
}
