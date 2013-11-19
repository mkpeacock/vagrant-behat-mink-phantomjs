<?php
require_once(__DIR__.'/../../vendor/autoload.php');
$namespaces = array(
    'Demo\\Content' => __DIR__.'/',
    'Demo\\Core' => __DIR__.'/',
    'Demo\\Pages' => __DIR__.'/',
    'Demo\\Users' => __DIR__.'/',
);

$loader = new \Symfony\Component\ClassLoader\UniversalClassLoader();
$loader->register();
$loader->registerNamespaces($namespaces);

$application = new \CentralApps\Base\Application(new \Demo\Core\Containers\Container(), __DIR__.'/');
$application->loadConfiguration(__DIR__.'/settings.xml');

// register any shared service providers
$application->registerServiceProvider(new \CentralApps\Base\ServiceProviders\SymfonyRoutingServiceProvider());
$application->registerServiceProvider(new \CentralApps\Base\ServiceProviders\PdoServiceProvider());
$application->registerServiceProvider(new \CentralApps\Base\ServiceProviders\TwigServiceProvider());
$application->registerServiceProvider(new \CentralApps\Base\ServiceProviders\PdoServiceProvider());

if ('web' === $application->getExecutionContext()) {
        // register web context related service providers
    $application->registerServiceProvider(new \CentralApps\Base\ServiceProviders\AuthenticationServiceProvider());
} else {
        // register cli contet related service providers
}

// allow any service providers to boot
$application->boot();
