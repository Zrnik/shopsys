# [Upgrade from v9.1.2 to v9.1.3-dev](https://github.com/shopsys/shopsys/compare/v9.1.2...9.1)

This guide contains instructions to upgrade from version v9.1.2 to v9.1.3-dev.

**Before you start, don't forget to take a look at [general instructions](https://github.com/shopsys/shopsys/blob/7.3/UPGRADE.md) about upgrading.**
There you can find links to upgrade notes for other versions too.

- use factory for creating class `ProductFilterData` ([#2380](https://github.com/shopsys/shopsys/pull/2380))
    - the class dependency on `ProductFilterDataFactory` was added in following classes:
        - `Shopsys\FrameworkBundle\Model\Product\ProductOnCurrentDomainElasticFacade`
        - `Shopsys\FrameworkBundle\Model\Product\ProductOnCurrentDomainFacade`
        - `Shopsys\FrontendApiBundle\Model\Product\Filter\ProductFilterDataMapper`
        - `Shopsys\FrontendApiBundle\Model\Product\Filter\ProductFilterFacade`
        - `Shopsys\FrontendApiBundle\Model\Product\ProductFacade`
    - see #project-base-diff
