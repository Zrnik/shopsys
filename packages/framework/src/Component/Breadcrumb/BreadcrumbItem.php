<?php

namespace Shopsys\FrameworkBundle\Component\Breadcrumb;

class BreadcrumbItem
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string|null
     */
    protected $routeName;

    /**
     * @var mixed[]
     */
    protected $routeParameters;

    /**
     * @param string $name
     * @param string|null $routeName
     * @param array $routeParameters
     */
    public function __construct($name, $routeName = null, array $routeParameters = [])
    {
        $this->name = $name;
        $this->routeName = $routeName;
        $this->routeParameters = $routeParameters;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getRouteName()
    {
        return $this->routeName;
    }

    /**
     * @return array
     */
    public function getRouteParameters()
    {
        return $this->routeParameters;
    }
}
