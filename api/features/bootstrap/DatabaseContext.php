<?php

use Behat\Behat\Context\Context;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @author Vincent Chalamon <vincent@les-tilleuls.coop>
 */
final class DatabaseContext implements Context
{
    /**
     * @var ManagerRegistry
     */
    private $registry;

    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * @BeforeScenario
     */
    public function createDatabase()
    {
        /** @var \Doctrine\ORM\EntityManagerInterface $manager */
        $manager = $this->registry->getManager();
        $purger = new ORMPurger($manager);
        $purger->setPurgeMode(ORMPurger::PURGE_MODE_TRUNCATE);
        $purger->purge();
        $manager->clear();
    }
}
