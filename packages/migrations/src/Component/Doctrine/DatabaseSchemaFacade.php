<?php

namespace Shopsys\MigrationBundle\Component\Doctrine;

use Doctrine\DBAL\Schema\Comparator;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;

class DatabaseSchemaFacade
{
    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    protected $em;

    /**
     * @var \Shopsys\MigrationBundle\Component\Doctrine\SchemaDiffFilter
     */
    protected $schemaDiffFilter;

    /**
     * @var \Doctrine\DBAL\Schema\Comparator
     */
    protected $comparator;

    /**
     * @var \Doctrine\ORM\Tools\SchemaTool
     */
    protected $schemaTool;

    /**
     * @param \Doctrine\ORM\EntityManagerInterface $em
     * @param \Shopsys\MigrationBundle\Component\Doctrine\SchemaDiffFilter $schemaDiffFilter
     * @param \Doctrine\DBAL\Schema\Comparator $comparator
     * @param \Doctrine\ORM\Tools\SchemaTool $schemaTool
     */
    public function __construct(
        EntityManagerInterface $em,
        SchemaDiffFilter $schemaDiffFilter,
        Comparator $comparator,
        SchemaTool $schemaTool
    ) {
        $this->em = $em;
        $this->schemaDiffFilter = $schemaDiffFilter;
        $this->comparator = $comparator;
        $this->schemaTool = $schemaTool;
    }

    /**
     * @return string[]
     */
    public function getFilteredSchemaDiffSqlCommands()
    {
        $allMetadata = $this->em->getMetadataFactory()->getAllMetadata();

        $databaseSchema = $this->em->getConnection()->createSchemaManager()->createSchema();
        $metadataSchema = $this->schemaTool->getSchemaFromMetadata($allMetadata);

        $schemaDiff = $this->comparator->compareSchemas($databaseSchema, $metadataSchema);
        $filteredSchemaDiff = $this->schemaDiffFilter->getFilteredSchemaDiff($schemaDiff);

        return $filteredSchemaDiff->toSaveSql($this->em->getConnection()->getDatabasePlatform());
    }
}
