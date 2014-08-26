<?php

namespace Extension\Menu;

use BinCMS\BaseExtension;
use Extension\Menu\Converter\MenuConverter;
use Silex\Application;

class Extension extends BaseExtension
{
    /**
     * Registers services on the given app.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Application $app An Application instance
     */
    public function register(Application $app)
    {
        $app
            ->registerDataRepository($this, 'Menu')
        ;

        $app
            ->registerExtensionController($this, 'Controller\\MenuController', '', function ($app) {
                return [
                    $app['extension.menu.repository.menu'],
                    $app['service.converter'],
                    $app['validator']
                ];
            })
        ;

        $app['converter_factory']
            ->registerConverter('Extension\\Menu\\Document\\Menu', new MenuConverter())
        ;
    }

    /**
     * Bootstraps the application.
     *
     * This method is called after all services are registered
     * and should be used for "dynamic" configuration (whenever
     * a service must be requested).
     */
    public function boot(Application $app)
    {

    }
}