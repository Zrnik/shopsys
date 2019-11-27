<?php

declare(strict_types=1);

namespace Shopsys\FrameworkBundle\Component\UploadedFile\Config;

class UploadedFileConfig
{
    /**
     * @var \Shopsys\FrameworkBundle\Component\UploadedFile\Config\UploadedFileEntityConfig[]
     */
    protected $uploadedFileEntityConfigsByClass;

    /**
     * @param \Shopsys\FrameworkBundle\Component\UploadedFile\Config\UploadedFileEntityConfig[] $uploadedFileEntityConfigsByClass
     */
    public function __construct(array $uploadedFileEntityConfigsByClass)
    {
        $this->uploadedFileEntityConfigsByClass = $uploadedFileEntityConfigsByClass;
    }

    /**
     * @param object $entity
     * @return string
     */
    public function getEntityName(object $entity): string
    {
        return $this->getUploadedFileEntityConfig($entity)->getEntityName();
    }

    /**
     * @param object $entity
     * @return \Shopsys\FrameworkBundle\Component\UploadedFile\Config\UploadedFileEntityConfig
     */
    public function getUploadedFileEntityConfig(object $entity): UploadedFileEntityConfig
    {
        foreach ($this->uploadedFileEntityConfigsByClass as $className => $entityConfig) {
            if ($entity instanceof $className) {
                return $entityConfig;
            }
        }

        throw new \Shopsys\FrameworkBundle\Component\UploadedFile\Config\Exception\UploadedFileEntityConfigNotFoundException(get_class($entity));
    }

    /**
     * @param object $entity
     * @return bool
     */
    public function hasUploadedFileEntityConfig(object $entity): bool
    {
        foreach ($this->uploadedFileEntityConfigsByClass as $className => $entityConfig) {
            if ($entity instanceof $className) {
                return true;
            }
        }
        return false;
    }

    /**
     * @return \Shopsys\FrameworkBundle\Component\UploadedFile\Config\UploadedFileEntityConfig[]
     */
    public function getAllUploadedFileEntityConfigs(): array
    {
        return $this->uploadedFileEntityConfigsByClass;
    }

    /**
     * @param string $entityClass
     * @return \Shopsys\FrameworkBundle\Component\UploadedFile\Config\UploadedFileEntityConfig
     */
    public function getUploadedFileEntityConfigByClass(string $entityClass): UploadedFileEntityConfig
    {
        foreach ($this->uploadedFileEntityConfigsByClass as $className => $entityConfig) {
            if ($entityClass === $className) {
                return $entityConfig;
            }
        }

        throw new \Shopsys\FrameworkBundle\Component\UploadedFile\Config\Exception\UploadedFileEntityConfigNotFoundException($entityClass);
    }
}
