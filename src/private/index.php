<?php
session_start();
//echo '<pre>' . print_r($_SESSION, true) . '</pre>';exit;
require_once(__DIR__.'/bootstrap.php');

$container = $application->getContainer();
try {
    $application->checkAuthentication();
} catch (\CentralApps\Base\Exceptions\InvalidLoginCredentialsException $e) {
    $application->getContainer()['dispatcher']->dispatch('login.failed', $container['standard_event']());
} catch (\Exception $e) {
    $event = $container['standard_event'](array( 'http_code' => 500, 'message' => $e->getMessage()));
    $container['dispatcher']->dispatch('friendly.error', $event);
    exit;
}

// TODO: move this to application view when migrating to proper views
$container['template_variables']['current_user'] = $application->getContainer()['current_user'];


$url = (isset($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : '';

$container['api_context'] = (isset($_SERVER['HTTP_ACCEPT']) && $_SERVER['HTTP_ACCEPT'] == 'application/json') ? true : false;

$routing_callback = function($route, $route_name = null) use ($container) {
    if (!is_null($route_name)) {
        $container['route_name'] = $route_name;
        if (extension_loaded('newrelic')) {
          newrelic_name_transaction($route_name);
        }
    }
    if (isset($route['logged_in']) && $route['logged_in'] == true && is_null($container['current_user'])) {
        throw new \Demo\Core\Exceptions\NotLoggedInException("You need to be logged in to view this page");
    }
};

try {
        $application->route($url, $remove_utm_tags = true, $variables_to_ignore = array('logged_in', 'super_admin_only'), $pre_processing_callback = $routing_callback);
} catch (\Demo\Core\Exceptions\NotLoggedInException $e) {
    $errors_controller = new \Demo\Core\Controllers\ErrorController($application->getContainer());
    $errors_controller->requiresLogin();
} catch (\Symfony\Component\Routing\Exception\ResourceNotFoundException $e) {
    $event = $container['standard_event'](array( 'http_code' => 404, 'message' => 'Page not found'));
    $container['dispatcher']->dispatch('friendly.error', $event);
} catch (\Symfony\Component\Routing\Exception\MethodNotAllowedException $e) {
    $event = $container['standard_event'](array( 'http_code' => 405, 'message' => 'Method not allowed'));
    $container['dispatcher']->dispatch('friendly.error', $event);
} catch (\Exception $e) {
    $event = $container['standard_event'](array( 'http_code' => 500, 'message' => $e->getMessage()));
    $container['dispatcher']->dispatch('friendly.error', $event);
}
exit;
