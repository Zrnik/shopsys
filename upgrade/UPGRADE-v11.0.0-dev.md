# [Upgrade from v10.0.0 to v11.0.0-dev](https://github.com/shopsys/shopsys/compare/v10.0.0...master)

This guide contains instructions to upgrade from version v10.0.0 to v11.0.0-dev.

**Before you start, don't forget to take a look at [general instructions](https://github.com/shopsys/shopsys/blob/master/UPGRADE.md) about upgrading.**
There you can find links to upgrade notes for other versions too.

## Removed deprecations

- check that your code don't use any removed code ([#2455](https://github.com/shopsys/shopsys/pull/2455))
    - Phing property `path.env.test` was removed
    - function `getCategoriesOrderingData()` from `@shopsys/framework/assets/js/admin/components/CategoryTreeSorting.js` was removed, use `getNestedSetData()` instead
    - method `Shopsys\FrameworkBundle\Controller\Admin\CategoryController::saveOrderAction()` was removed, use `applySortingAction()` instead
    - method `Shopsys\FrameworkBundle\Model\Category\CategoryFacade::editOrdering()` was removed, use `reorderByNestedSetValues()` instead
    - data transformer `Shopsys\FrameworkBundle\Form\Transformers\ScriptPlacementToBooleanTransformer` was removed as it's not necessary anymore
    - command `Shopsys\FrameworkBundle\Command\ElFinderPostInstallCommand` was removed, set proper public dir with `--docroot` option in `elfinder:install` command
    - class `Shopsys\FrameworkBundle\Component\Csv\CsvReader` was removed, use `SplFileObject::fgetcsv()` instead
    - command `Shopsys\FrameworkBundle\Command\Elasticsearch\ElasticsearchIndexesCreateCommand` was removed, use `ElasticsearchIndexesMigrateCommand` instead
    - method `Shopsys\FrameworkBundle\Component\Elasticsearch\IndexDefinition::getLegacyIndexAlias()` was removed
    - visibility of method `Shopsys\FrameworkBundle\Component\Elasticsearch\IndexFacade::create()` was changed to `protected`
    - method `Shopsys\FrameworkBundle\Component\Elasticsearch\Exception\ElasticsearchIndexException::indexAlreadyExists()` was removed, use `ElasticsearchIndexAlreadyExistsException` directly
    - class `Shopsys\FrameworkBundle\Component\DataFixture\AbstractNativeFixture` was removed
    - removed constant `Shopsys\FrameworkBundle\Component\Environment\EnvironmentFileSetting\ENVIRONMENTS_CONSOLE`
    - `Shopsys\FrameworkBundle\Component\Router\DomainRouterFactory`
        - property `$configLoader` was removed
        - property `$container` is no longer nullable
        - property `$cacheDir`  is no longer nullable
        - method `__construct`  changed its interface:
            ```diff
                public function __construct(
                    $routerConfiguration,
            -       ?LoaderInterface $configLoader,
                    LocalizedRouterFactory $localizedRouterFactory,
                    FriendlyUrlRouterFactory $friendlyUrlRouterFactory,
                    Domain $domain,
                    RequestStack $requestStack,
            -       ?ContainerInterface $container = null,
            +       ContainerInterface $container,
            -       ?string $cacheDir = null
            +       string $cacheDir
                )
            ```
    - `Shopsys\FrameworkBundle\Component\Router\LocalizedRouterFactory`
        - property `$configLoader` was removed
        - property `$container` is no longer nullable
        - property `$cacheDir`  is no longer nullable
        - method `__construct`  changed its interface:
            ```diff
                public function __construct(
                    $localeRoutersResourcesFilepathMask,
            -       ?LoaderInterface $configLoader = null,
            -       ?ContainerInterface $container = null,
            +       ContainerInterface $container,
            -       ?string $cacheDir = null
            +       string $cacheDir
                )
            ```
    - `Shopsys\FrameworkBundle\Model\AdvancedSearch\Filter\ProductCategoryFilter`
        - property `$domain` was removed
        - method `__construct`  changed its interface:
            ```diff
                public function __construct(
                    CategoryFacade $categoryFacade,
            -       ?Domain $domain = null,
            -       ?LocalizationAlias $localization = null
            +       Localization $localization
                )
            ```
    - class `Shopsys\FrameworkBundle\Model\Breadcrumb\ErrorPageBreadcrumbGenerator` was changed to abstract, don't forget to extend this class and implement following methods:
        - `getTranslatedBreadcrumbForNotFoundPage()`
        - `getTranslatedBreadcrumbForErrorPage()`
    - class `Shopsys\FrameworkBundle\Model\Breadcrumb\SimpleBreadcrumbGenerator` was changed to abstract, don't forget to extend this class and implement following methods:
        - `getTranslatedBreadcrumbsByRouteNames()`
    - class `Shopsys\FrameworkBundle\Model\Cart\Watcher\CartWatcherFacade` was changed to abstract, don't forget to extend this class and implement following methods:
        - `getMessageForNoLongerAvailableExistingProduct()`
        - `getMessageForNoLongerAvailableProduct()`
        - `getMessageForChangedProduct()`
    - class `Shopsys\FrameworkBundle\Model\LegalConditions\LegalConditionsFacade` was changed to abstract, don't forget to extend this class and implement following methods:
        - `getTermsAndConditionsDownloadFilename()`
    - class `Shopsys\FrameworkBundle\Model\Product\Listing\ProductListOrderingModeForBrandFacade` was changed to abstract, don't forget to extend this class and implement following methods:
        - `getSupportedOrderingModesNamesById()`
    - class `Shopsys\FrameworkBundle\Model\Product\Listing\ProductListOrderingModeForListFacade` was changed to abstract, don't forget to extend this class and implement following methods:
        - `getSupportedOrderingModesNamesById()`
    - class `Shopsys\FrameworkBundle\Model\Product\Listing\ProductListOrderingModeForSearchFacade` was changed to abstract, don't forget to extend this class and implement following methods:
        - `getSupportedOrderingModesNamesById()`
    - method `Shopsys\FrameworkBundle\Model\Category\CategoryFacade::getTranslatedAll()` was removed, use `getAllTranslated()` instead
    - method `Shopsys\FrameworkBundle\Model\Category\CategoryFacade::getTranslatedAllWithoutBranch` was removed, use `getAllTranslatedWithoutBranch()` instead
    - method `Shopsys\FrameworkBundle\Model\Category\CategoryRepository::getTranslatedAll()` was removed, use `getAllTranslated()` instead
    - method `Shopsys\FrameworkBundle\Model\Category\CategoryRepository::getTranslatedAllWithoutBranch()` was removed, use `getAllTranslatedWithoutBranch()` instead
    - method `Shopsys\FrameworkBundle\Model\Category\CategoryRepository::addTranslationPublic()` was removed
        - use `addTranslation()`, which visibility was changed to public
    - method `Shopsys\FrameworkBundle\Model\Category\CategoryRepository::filterBySearchTextPublic()` was removed
        - use `filterBySearchText()`, which visibility was changed to public
    - method `Shopsys\FrameworkBundle\Model\Pricing\PriceConverter::convertPriceWithoutVatToPriceInDomainDefaultCurrency()` was removed, use `convertPriceWithoutVatToDomainDefaultCurrencyPrice()` instead
    - method `Shopsys\FrameworkBundle\Model\Pricing\PriceConverter::convertPriceWithVatToPriceInDomainDefaultCurrency()` was removed, use `convertPriceWithVatToDomainDefaultCurrencyPrice()` instead
    - method `Shopsys\FrameworkBundle\Model\Pricing\PriceConverter::__construct()` changed its interface:
        ```diff
            public function __construct(
                CurrencyFacade $currencyFacade,
                Rounding $rounding,
        -       ?Setting $setting = null
        +       Setting $setting
            )
        ```
    - method `Shopsys\FrameworkBundle\Model\Pricing\PriceConverter::convertPriceWithoutVatToPriceInDomainDefaultCurrency()` was removed, use `convertPriceWithoutVatToDomainDefaultCurrencyPrice'()` instead
    - method `Shopsys\FrameworkBundle\Model\Pricing\PriceConverter::convertPriceWithVatToPriceInDomainDefaultCurrency()` was removed, use `convertPriceWithVatToDomainDefaultCurrencyPrice'()` instead
    - method `Shopsys\FrameworkBundle\Model\Product\ProductFacade::getSellableByUuid` was removed, use method with the same name from the `Shopsys\FrontendApiBundle\Model\Product` namespace (you have to have shopsys/frontend-api package installed)
    - method `Shopsys\FrameworkBundle\Model\Product\ProductRepository::getSellableByUuid` was removed, use method with the same name from the `Shopsys\FrontendApiBundle\Model\Product` namespace (you have to have shopsys/frontend-api package installed)
    - method `Shopsys\FrameworkBundle\Model\Product\ProductRepository::getListableForBrandQueryBuilderPublic()` was removed
        - use `getListableForBrandQueryBuilder()`, which visibility was changed to public
    - `Shopsys\FrameworkBundle\Model\Product\ProductOnCurrentDomainElasticFacade`:
        - method `createListableProductsInCategoryFilterQuery()` was removed, use `Shopsys\FrameworkBundle\Model\Product\Search\FilterQueryFactory::createListableProductsByCategoryId()` instead
        - method `createListableProductsForBrandFilterQuery()` was removed, use `Shopsys\FrameworkBundle\Model\Product\Search\FilterQueryFactory::createListableProductsByBrandId` instead
        - method `createListableProductsForSearchTextFilterQuery()` was removed, use `Shopsys\FrameworkBundle\Model\Product\Search\FilterQueryFactory::createListableProductsBySearchText()` instead
        - method `createFilterQueryWithProductFilterData()` was removed, use `Shopsys\FrameworkBundle\Model\Product\Search\FilterQueryFactory::createWithProductFilterData()` instead
        - method `getIndexName()` was removed, use `Shopsys\FrameworkBundle\Model\Product\Search\FilterQueryFactory::getIndexName()` instead
        - method `getProductsCountOnCurrentDomain()` was removed, use `Shopsys\FrontendApiBundle\Model\Product\ProductFacade::getFilteredProductsCountOnCurrentDomain()` (you have to have shopsys/frontend-api package installed)
        - method `getProductsOnCurrentDomain()` was removed, use `Shopsys\FrontendApiBundle\Model\Product\ProductFacade::getFilteredProductsOnCurrentDomain()` (you have to have shopsys/frontend-api package installed)
        - method `getProductsByCategory()` was removed, use `Shopsys\FrontendApiBundle\Model\Product\ProductFacade::getFilteredProductsByCategory()` (you have to have shopsys/frontend-api package installed)
    - `Shopsys\FrameworkBundle\Model\Product\ProductOnCurrentDomainFacade`
        - method `getProductsCountOnCurrentDomain()` was removed, use `Shopsys\FrontendApiBundle\Model\Product\ProductFacade::getFilteredProductsCountOnCurrentDomain()` (you have to have shopsys/frontend-api package installed)
        - method `getProductsOnCurrentDomain()` was removed, use `Shopsys\FrontendApiBundle\Model\Product\ProductFacade::getFilteredProductsOnCurrentDomain()` (you have to have shopsys/frontend-api package installed)
        - method `getProductsByCategory()` was removed, use `Shopsys\FrontendApiBundle\Model\Product\ProductFacade::getFilteredProductsByCategory()` (you have to have shopsys/frontend-api package installed)
    - `Shopsys\FrameworkBundle\Model\Product\ProductOnCurrentDomainFacadeInterface`:
        - method `getProductsCountOnCurrentDomain()` was removed
        - method `getProductsOnCurrentDomain()` was removed
        - method `getProductsByCategory()` was removed
    - constant `Shopsys\FrameworkBundle\Model\Product\BestsellingProduct\BestsellingProductFacade::MAX_RESULTS` was removed
    - method `Shopsys\FrameworkBundle\Model\Script\ScriptFacade::getAllPagesScriptCodes()` was removed, use `getAllPagesBeforeContentScriptCodes()` instead
    - all unnecessary service definitions were removed from `services_test.yaml` file
    - removed `Shopsys\FrameworkBundle\Component\FileUpload\DeleteOldUploadedFilesCronModule` cron definition from shopsys/framework package, add this cron to your project config (it should be already set in cron.yaml if you properly followed all the previous upgrade notes or started your project on at least 9.0.2 version of Shopsys Framework)
    - removed css class `js-order-sent-page-variables` from `shopsys/framework/src/Resources/views/Admin/Content/Script/detail.html.twig`
    - `Shopsys\FrontendApiBundle\Model\Product\ProductFacade`
        - method `getProductsCountOnCurrentDomain()` was removed, use `getFilteredProductsCountOnCurrentDomain()` instead
        - method `getProductsOnCurrentDomain()` was removed, use `getFilteredProductsOnCurrentDomain()` instead
        - method `getProductsByCategory()` was removed, use `getFilteredProductsByCategory()` instead
        - method `getProductsByCategoryCount()` was removed, use `getFilteredProductsByCategoryCount()` instead
        - method `getProductsByBrand()` was removed, use `getFilteredProductsByBrand()` instead
        - method `getProductsByBrandCount()` was removed, use `getFilteredProductsByBrandCount()` instead
    - removed parameter `shopsys.var_dir` from shopsys/framework package, add this parameter to your project config (it should be already set in paths.yaml if you properly followed all the previous upgrade notes or started your project on at least 9.0.2 version of Shopsys Framework)
    - `Shopsys\FrontendApiBundle\Component\Constraints\ProductCanBeOrderedValidator`
        - property `$productFacade` was removed
        - property `$frontendApiProductFacade` is no longer nullable
        - method `__construct()` changed its interface:
            ```diff
                public function __construct(
            -       ProductFacade $productFacade,
                    ProductCachedAttributesFacade $productCachedAttributesFacade,
                    Domain $domain,
                    CurrentCustomerUser $currentCustomerUser,
            -       ?FrontendApiProductFacade $frontendApiProductFacade = null
            +       FrontendApiProductFacade $frontendApiProductFacade
                )
            ```
    - method `Shopsys\FrameworkBundle\Model\Article\ArticleRepository::getVisibleArticlesByDomainIdAndPlacementSortedByPositionQueryBuilder()` changed its visibility to `public`
    - method `Shopsys\FrameworkBundle\Model\Article\ArticleRepository::getAllVisibleQueryBuilder` changed its visibility to `public`
    - method `Shopsys\FrameworkBundle\Model\Article\ArticleRepository::getArticlesByDomainIdQueryBuilder` changed its visibility to `public`
    - `Shopsys\FrontendApiBundle\Model\Article\ArticleRepository`
        - property `$em` was removed
        - method `__construct()` changed its interface
            ```diff
            -   public function __construct(FrameworkArticleRepository $articleRepository, EntityManagerInterface $em)
            +   public function __construct(FrameworkArticleRepository $articleRepository)
            ```
        - method `getVisibleArticlesByDomainIdAndPlacementSortedByPositionQueryBuilder()` was removed, use method with the same name from the `Shopsys\FrameworkBundle\Model\Article\ArticleRepository` class
        - method `getArticlesByDomainIdQueryBuilder()` was removed, use method with the same name from the `Shopsys\FrameworkBundle\Model\Article\ArticleRepository` class
        - method `getAllVisibleQueryBuilder()` was removed, use method with the same name from the `Shopsys\FrameworkBundle\Model\Article\ArticleRepository` class
    - `Shopsys\FrontendApiBundle\Model\Resolver\Category\CategoryResolver`
        - property `$domain` is no longer nullable
        - property `$friendlyUrlFacade` is no longer nullable
        - method `__construct()` changed its interface
            ```diff
                public function __construct(
                    CategoryFacade $categoryFacade,
            -       ?Domain $domain = null,
            +       Domain $domain,
            -       ?FriendlyUrlFacade $friendlyUrlFacade = null
            +       FriendlyUrlFacade $friendlyUrlFacade
                )
            ```
        - method `resolver` used as resolver with an alias `category` was removed, use `resolveByUuidOrUrlSlug` method and resolver alias instead
    - class `Shopsys\FrontendApiBundle\Model\Resolver\Products\ProductResolver` used as resolver with alias `product` was removed, use `ProductDetailResolver` with alias `productDetail` instead
    - `Shopsys\FrontendApiBundle\Model\Resolver\Products\ProductResolverMap`
        - method `getProductLink()` was removed, use mapping via appropriate class `DataMapper\Product*FieldMapper` instead
        - method `getFlagsForData()` was removed, use mapping via appropriate class `DataMapper\Product*FieldMapper` instead
        - method `getCategoriesForData()`  was removed, use mapping via appropriate class `DataMapper\Product*FieldMapper` instead
        - property `$domain` was removed
        - property `$productCollectionFacade` was removed
        - property `flagFacade` was removed
        - property `$categoryFacade` was removed
        - method `__construct` changed its interface
            ```diff
                public function __construct(
            -       Domain $domain,
            -       ProductCollectionFacade $productCollectionFacade,
            -       FlagFacade $flagFacade,
            -       CategoryFacade $categoryFacade,
            -       ?ProductEntityFieldMapper $productEntityFieldMapper = null,
            +       ProductEntityFieldMapper $productEntityFieldMapper,
            -       ?ProductArrayFieldMapper $productArrayFieldMapper = null
            +       ProductArrayFieldMapper $productArrayFieldMapper
                )
            ```
    - `Shopsys\FrontendApiBundle\Model\Resolver\Products\ProductsResolver`
        - constant `EDGE_COUNT` was removed
        - property `$productOnCurrentDomainFacade` was removed
        - property `$productFacade` is no longer nullable
        - property `$productFilterFacade` is no longer nullable
        - property `$productConnectionFactory` is no longer nullable
        - method `__construct` changed its interface
            ```diff
                public function __construct(
            -       ProductOnCurrentDomainFacadeInterface $productOnCurrentDomainFacade,
            -       ?ProductFacade $productFacade = null,
            +       ProductFacade $productFacade,
            -       ?ProductFilterFacade $productFilterFacade = null,
            +       ProductFilterFacade $productFilterFacade,
            -       ?ProductConnectionFactory $productConnectionFactory = null
            +       ProductConnectionFactory $productConnectionFactory
                )
            ```
    - method `Shopsys\ReadModelBundle\Image\ImageViewFacade::getForEntityIds()` was removed, use `getMainImagesByEntityIds()` instead
    - method `Shopsys\ReadModelBundle\Product\Action\ProductActionViewFacade::getForArray()` was removed, use `ProductActionViewFactory::createFromArray()` instead
    - `Shopsys\ReadModelBundle\Product\Listed\ListedProductViewElasticFacade`
        - property `$productActionViewFacade` was removed
        - method `createFromProducts()` was removed, use `Shopsys\ReadModelBundle\Product\Listed\ListedProductViewFactory::createFromProducts()` instead
        - method `getIdsForProducts()` was removed, use `Shopsys\ReadModelBundle\Product\Listed\ListedProductViewFactory::getIdsForProducts()` instead
        - method `__construct` changed its interface
            ```diff
                public function __construct(
                    ProductFacade $productFacade,
                    ProductAccessoryFacade $productAccessoryFacade,
                    Domain $domain,
                    CurrentCustomerUser $currentCustomerUser,
                    TopProductFacade $topProductFacade,
                    ProductOnCurrentDomainFacadeInterface $productOnCurrentDomainFacade,
                    ListedProductViewFactory $listedProductViewFactory,
            -       ProductActionViewFacade $productActionViewFacade,
                    ImageViewFacadeInterface $imageViewFacade,
            -       ?ProductActionViewFactory $productActionViewFactory = null,
            +       ProductActionViewFactory $productActionViewFactory,
            -       ?ProductElasticsearchProvider $productElasticsearchProvider = null
            +       ProductElasticsearchProvider $productElasticsearchProvider
                )
            ```
    - `Shopsys\ReadModelBundle\Product\Listed\ListedProductViewFacade`
        - property `$imageViewFacade` was removed
        - property `$productActionViewFacade` was removed
        - method `createFromProducts()` was removed, use `Shopsys\ReadModelBundle\Product\Listed\ListedProductViewFactory::createFromProducts()` instead
        - method `getIdsForProducts()` was removed, use `Shopsys\ReadModelBundle\Product\Listed\ListedProductViewFactory::getIdsForProducts()` instead
        - method `__construct` changed its interface
            ```diff
                public function __construct(
                    ProductFacade $productFacade,
                    ProductAccessoryFacade $productAccessoryFacade,
                    Domain $domain,
                    CurrentCustomerUser $currentCustomerUser,
                    TopProductFacade $topProductFacade,
                    ProductOnCurrentDomainFacadeInterface $productOnCurrentDomainFacade,
            -       ListedProductViewFactory $listedProductViewFactory,
            -       ProductActionViewFacade $productActionViewFacade,
            -       ImageViewFacade $imageViewFacade
            +       ListedProductViewFactory $listedProductViewFactory
                )
            ```
    - `Shopsys\ReadModelBundle\Product\Listed\ListedProductViewFactory`
        - method `getProductPriceFromArrayByPricingGroup()` was removed, use `Shopsys\FrameworkBundle\Model\Product\Pricing\PriceFactory::createProductPriceFromArrayByPricingGroup()`
        - method `__construct` changed its interface
            ```diff
                public function __construct(
                    Domain $domain,
                    ProductCachedAttributesFacade $productCachedAttributesFacade,
            -       ?ImageViewFacadeInterface $imageViewFacade = null,
            +       ImageViewFacadeInterface $imageViewFacade,
            -       ?ProductActionViewFacadeInterface $productActionViewFacade = null,
            +       ProductActionViewFacadeInterface $productActionViewFacade,
            -       ?ProductActionViewFactory $productActionViewFactory = null,
            +       ProductActionViewFactory $productActionViewFactory,
            -       ?CurrentCustomerUser $currentCustomerUser = null,
            +       CurrentCustomerUser $currentCustomerUser,
            -       ?PriceFactory $priceFactory = null
            +       PriceFactory $priceFactory
                )
            ```
    - method `Shopsys\FrameworkBundle\Component\Environment\EnvironmentFileSetting::getEnvironment()` changed its interface
        ```diff
        -   public function getEnvironment(?bool $console = null): string
        +   public function getEnvironment(): string
        ```
    - `Shopsys\FrameworkBundle\Component\Router\FriendlyUrl\FriendlyUrlFacade`
        - property `$friendlyUrlCacheKeyProvider` is no longer nullable
        - property `$mainFriendlyUrlSlugCache` is no longer nullable
        - method `__construct` changed its interface
            ```diff
                public function __construct(
                    EntityManagerInterface $em,
                    DomainRouterFactory $domainRouterFactory,
                    FriendlyUrlUniqueResultFactory $friendlyUrlUniqueResultFactory,
                    FriendlyUrlRepository $friendlyUrlRepository,
                    Domain $domain,
                    FriendlyUrlFactoryInterface $friendlyUrlFactory,
            -       ?FriendlyUrlCacheKeyProvider $friendlyUrlCacheKeyProvider = null,
            +       FriendlyUrlCacheKeyProvider $friendlyUrlCacheKeyProvider,
            -       ?CacheInterface $mainFriendlyUrlSlugCache = null
            +       CacheInterface $mainFriendlyUrlSlugCache
                )
            ```
    - `Shopsys\FrameworkBundle\Component\Router\FriendlyUrl\FriendlyUrlGenerator`
        - property `$friendlyUrlCacheKeyProvider` is no longer nullable
        - property `$mainFriendlyUrlSlugCache` is no longer nullable
        - method `__construct` changed its interface
            ```diff
                public function __construct(
                    RequestContext $context,
                    FriendlyUrlRepository $friendlyUrlRepository,
            -       ?FriendlyUrlCacheKeyProvider $friendlyUrlCacheKeyProvider = null,
            +       FriendlyUrlCacheKeyProvider $friendlyUrlCacheKeyProvider,
            -       ?CacheInterface $mainFriendlyUrlSlugCache = null
            +       CacheInterface $mainFriendlyUrlSlugCache
                )
            ```
    - method `Shopsys\FrameworkBundle\Model\Feed\FeedExportFactory::create()` changed its interface
        ```diff
            public function create(
                FeedInterface $feed,
                DomainConfig $domainConfig,
        -       $lastSeekId = null
        +       ?int $lastSeekId = null
            )
        ```
    - method `Shopsys\FrameworkBundle\Model\Product\Pricing\PriceFactory::createProductPriceFromArrayByPricingGroup()` changed its return type and now can throw `NoProductPriceForPricingGroupException`
        ```diff
            public function createProductPriceFromArrayByPricingGroup(
                array $pricesArray,
                PricingGroup $pricingGroup
        -   ): ?ProductPrice
        +   ): ProductPrice
        ```
    - method `Shopsys\FrontendApiBundle\Model\Price\PriceFacade::createProductPriceFromArrayForCurrentCustomer()` changed its return type and now can throw `NoProductPriceForPricingGroupException`
        ```diff
            public function createProductPriceFromArrayForCurrentCustomer(
                array $pricesArray
        -   ): ?ProductPrice
        +   ): ProductPrice
        ```
    - `Shopsys\FrameworkBundle\Command\CronCommand`
        - property `$parameterBag` is no longer nullable
        - method `__construct` changed its interface
            ```diff
                public function __construct(
                    CronFacade $cronFacade,
                    MutexFactory $mutexFactory,
            -       ?ParameterBagInterface $parameterBag = null
            +       ParameterBagInterface $parameterBag
                )
            ```
    - `Shopsys\FrameworkBundle\Component\Elasticsearch\AbstractExportChangedCronModule`
        - property `$eventDispatcher` is no longer nullable
        - method `__construct` changed its interface
            ```diff
                public function __construct(
                    AbstractIndex $index,
                    IndexFacade $indexFacade,
                    IndexDefinitionLoader $indexDefinitionLoader,
                    Domain $domain,
            -       ?EventDispatcherInterface $eventDispatcher = null
            +       EventDispatcherInterface $eventDispatcher
                )
            ```
    - `Shopsys\FrameworkBundle\Component\FileUpload\FileUpload`
        - property `$parameterBag` is no longer nullable
        - method `__construct` changed its interface
            ```diff
                public function __construct(
                    FileNamingConvention $fileNamingConvention,
                    MountManager $mountManager,
                    FilesystemInterface $filesystem,
            -       ?ParameterBagInterface $parameterBag = null
            +       ParameterBagInterface $parameterBag
                )
            ```
    - `Shopsys\FrameworkBundle\Component\Image\Config\ImageConfig`
        - property `$entityNameResolver` is no longer nullable
        - method `__construct` changed its interface
            ```diff
                public function __construct(
                    array $imageEntityConfigsByClass,
            -       ?EntityNameResolver $entityNameResolver = null
            +       EntityNameResolver $entityNameResolver
                )
            ```
    - `Shopsys\FrameworkBundle\Component\Image\Config\ImageConfigLoader`
        - property `$entityNameResolver` is no longer nullable
        - method `__construct` changed its interface
            ```diff
                public function __construct(
                    Filesystem $filesystem,
            -       ?EntityNameResolver $entityNameResolver = null
            +       EntityNameResolver $entityNameResolver
                )
            ```
    - `Shopsys\FrameworkBundle\Component\Router\FriendlyUrl\FriendlyUrlRouterFactory`
        - property `$friendlyUrlCacheKeyProvider` is no longer nullable
        - property `$mainFriendlyUrlSlugCache` is no longer nullable
        - method `__construct` changed its interface
            ```diff
                public function __construct(
                    $friendlyUrlRouterResourceFilepath,
                    LoaderInterface $configLoader,
                    FriendlyUrlRepository $friendlyUrlRepository,
            -       ?FriendlyUrlCacheKeyProvider $friendlyUrlCacheKeyProvider = null,
            +       FriendlyUrlCacheKeyProvider $friendlyUrlCacheKeyProvider,
            -       ?CacheInterface $mainFriendlyUrlSlugCache = null
            +       CacheInterface $mainFriendlyUrlSlugCache
                )
            ```
    - `Shopsys\FrameworkBundle\Controller\Admin\CustomerController`
        - property `$domain` is no longer nullable
        - method `__construct` changed its interface
            ```diff
                public function __construct(
                    CustomerUserDataFactoryInterface $customerUserDataFactory,
                    CustomerUserListAdminFacade $customerUserListAdminFacade,
                    CustomerUserFacade $customerUserFacade,
                    BreadcrumbOverrider $breadcrumbOverrider,
                    AdministratorGridFacade $administratorGridFacade,
                    GridFactory $gridFactory,
                    AdminDomainTabsFacade $adminDomainTabsFacade,
                    OrderFacade $orderFacade,
                    LoginAsUserFacade $loginAsUserFacade,
                    DomainRouterFactory $domainRouterFactory,
                    CustomerUserUpdateDataFactoryInterface $customerUserUpdateDataFactory,
            -       ?Domain $domain = null
            +       Domain $domain
                )
            ```
    - `Shopsys\FrameworkBundle\Model\Customer\User\CustomerUserPasswordFacade`
        - property `$customerUserRefreshTokenChainFacade` is no longer nullable
        - method `__construct` changed its interface
            ```diff
                public function __construct(
                    EntityManagerInterface $em,
                    CustomerUserRepository $customerUserRepository,
                    EncoderFactoryInterface $encoderFactory,
                    ResetPasswordMailFacade $resetPasswordMailFacade,
                    HashGenerator $hashGenerator,
            -       ?CustomerUserRefreshTokenChainFacade $customerUserRefreshTokenChainFacade = null
            +       CustomerUserRefreshTokenChainFacade $customerUserRefreshTokenChainFacade
                )
            ```
    - `Shopsys\FrameworkBundle\Model\Product\ProductDataFactory`
        - property `$availabilityFacade` is no longer nullable
        - method `__construct` changed its interface
            ```diff
                public function __construct(
                    VatFacade $vatFacade,
                    ProductInputPriceFacade $productInputPriceFacade,
                    UnitFacade $unitFacade,
                    Domain $domain,
                    ProductRepository $productRepository,
                    ParameterRepository $parameterRepository,
                    FriendlyUrlFacade $friendlyUrlFacade,
                    ProductAccessoryRepository $productAccessoryRepository,
                    ImageFacade $imageFacade,
                    PluginCrudExtensionFacade $pluginDataFormExtensionFacade,
                    ProductParameterValueDataFactoryInterface $productParameterValueDataFactory,
                    PricingGroupFacade $pricingGroupFacade,
            -       ?AvailabilityFacade $availabilityFacade = null
            +       AvailabilityFacade $availabilityFacade
                )
            ```
    - `Shopsys\FrameworkBundle\Model\Product\Elasticsearch\ProductExportRepository`
        - property `$categoryFacade` is no longer nullable
        - property `$productAccessoryFacade` is no longer nullable
        - property `$brandCachedFacade` is no longer nullable
        - method `__construct` changed its interface
            ```diff
                public function __construct(
                    EntityManagerInterface $em,
                    ParameterRepository $parameterRepository,
                    ProductFacade $productFacade,
                    FriendlyUrlRepository $friendlyUrlRepository,
                    Domain $domain,
                    ProductVisibilityRepository $productVisibilityRepository,
                    FriendlyUrlFacade $friendlyUrlFacade,
            -       ?CategoryFacade $categoryFacade = null,
            +       CategoryFacade $categoryFacade,
            -       ?ProductAccessoryFacade $productAccessoryFacade = null,
            +       ProductAccessoryFacade $productAccessoryFacade,
            -       ?BrandCachedFacade $brandCachedFacade = null
            +       BrandCachedFacade $brandCachedFacade
                )
            ```
    - `Shopsys\FrameworkBundle\Twig\UploadedFileExtension`
        - property `$uploadedFileLocator` is no longer nullable
        - method `__construct` changed its interface
            ```diff
                public function __construct(
                    Domain $domain,
                    UploadedFileFacade $uploadedFileFacade,
                    FileThumbnailExtension $fileThumbnailExtension,
            -       ?UploadedFileLocator $uploadedFileLocator = null
            +       UploadedFileLocator $uploadedFileLocator
                )
            ```
    - `Shopsys\FrontendApiBundle\Controller\FrontendApiController`
        - property `$graphqlConfigurator` is no longer nullable
        - method `__construct` changed its interface
            ```diff
                public function __construct(
                    GraphController $graphController,
                    EnabledOnDomainChecker $enabledOnDomainChecker,
            -       ?GraphqlConfigurator $graphqlConfigurator = null
            +       GraphqlConfigurator $graphqlConfigurator
                )
            ```
    - `Shopsys\FrontendApiBundle\Model\Resolver\Image\ImagesResolver`
        - property `$frontendApiImageFacade` is no longer nullable
        - method `__construct` changed its interface
            ```diff
                public function __construct(
                    ImageFacade $imageFacade,
                    ImageConfig $imageConfig,
                    Domain $domain,
            -       ?FrontendApiImageFacade $frontendApiImageFacade = null
            +       FrontendApiImageFacade $frontendApiImageFacade
                )
            ```
    - `Shopsys\FrontendApiBundle\Model\Resolver\Price\PriceResolver`
        - property `$priceFacade` is no longer nullable
        - method `__construct` changed its interface
            ```diff
                public function __construct(
                    ProductCachedAttributesFacade $productCachedAttributesFacade,
                    ProductOnCurrentDomainFacadeInterface $productOnCurrentDomainFacade,
                    PaymentPriceCalculation $paymentPriceCalculation,
                    Domain $domain,
                    CurrencyFacade $currencyFacade,
                    TransportPriceCalculation $transportPriceCalculation,
            -       ?PriceFacade $priceFacade = null
            +       PriceFacade $priceFacade
                )
            ```
    - `Shopsys\FrameworkBundle\Component\Image\ImageFacade`
        - property `$logger` is no longer nullable
        - method `__construct` changed its interface
            ```diff
                public function __construct(
                    $imageUrlPrefix,
                    EntityManagerInterface $em,
                    ImageConfig $imageConfig,
                    ImageRepository $imageRepository,
                    FilesystemInterface $filesystem,
                    FileUpload $fileUpload,
                    ImageLocator $imageLocator,
                    ImageFactoryInterface $imageFactory,
                    MountManager $mountManager,
            -       ?LoggerInterface $logger = null
            +       LoggerInterface $logger
                )
            ```
    - `Shopsys\FrameworkBundle\Model\Mail\Mailer`
        - property `$logger` is no longer nullable
        - method `__construct` changed its interface
            ```diff
                public function __construct(
                    Swift_Mailer $swiftMailer,
                    Swift_Transport $realSwiftTransport,
                    MailTemplateFacade $mailTemplateFacade,
            -       ?LoggerInterface $logger = null
            +       LoggerInterface $logger
                )
            ```

## Application

- remove unnecessary extended ImageExtension from your project, if you don't have any custom changes in the extension
    - see #project-base-diff to update your project
- remove unnecessary `services_acc.yaml` config from your project
    - create `config/packages/acc/framework.yaml` with configuration for acceptance testing
    - see #project-base-diff to update your project
- move `paths.yml` config file into packages subfolder to allow easy override them for different environments
    - see #project-base-diff to update your project
- set overwrite domain url to be taken exclusively from environment variable
    - see #project-base-diff to update your project
- set redis host to be taken exclusively from environment variable
    - see #project-base-diff to update your project
- set swift mailer configuration to be taken exclusively from environment variable
    - see #project-base-diff to update your project
- set application secret to be taken exclusively from environment variable
    - see #project-base-diff to update your project
- set doctrine configuration to be taken exclusively from environment variables
    - see #project-base-diff to update your project
- unused translations have been removed
    - the following `msgid` entries are no longer available in framework, they should be already added into your project directly
        - `Contact`
        - `Edit data`
        - `Forgotten password`
        - `Oops! Error occurred`
        - `Page not found`
        - `Product <strong>{{ name }}</strong> you had in cart is no longer available. Please check your order.`
        - `Product you had in cart is no longer in available. Please check your order.`
        - `Registration`
        - `Search [noun]`
        - `TOP`
        - `Terms-and-conditions.html`
        - `The price of the product <strong>{{ name }}</strong> you have in cart has changed. Please, check your order.`
        - `alphabetically A -> Z`
        - `alphabetically Z -> A`
        - `from most expensive`
        - `from the cheapest`
        - `relevance`
- `parameter(_test).yaml.dist` and auto-creation of `parameter(_test).yaml` files was removed
    - see #project-base-diff to update your project
    - you can create `parameters.yaml` manually to locally override some settings (for testing purposes for example)
    - your custom parameters should be in environment variable (if the value is environment-specific), or in different config file (if the value is project-specific)
- fix implementations of FileVisitorInterface::visitTwigFile ([#2465](https://github.com/shopsys/shopsys/pull/2465))
    - in the following classes, an interface of `visitTwigFile` was fixed to comply with `FileVisitorInterface`
        - `ConstraintMessageExtractor`
        - `ConstraintMessagePropertyExtractor`
        - `ConstraintViolationExtractor`
        - `JsFileExtractor`
        - `PhpFileExtractor`
        - `TwigFileExtractor`
