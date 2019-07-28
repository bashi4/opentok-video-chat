<?php
namespace App;

use \Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface {

    public function register(\Pimple\Container $container)
    {          
        return $container;
    }
}
