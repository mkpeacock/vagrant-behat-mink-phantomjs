<?php
namespace Demo\Core\Events\Listeners;

class WebErrorListener
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function friendlyError($event)
    {
        $details = $event->getPayload();
        $details['url'] = $_SERVER['REQUEST_URI'];
        switch ($details['http_code']) {
            case 404:
                header("HTTP/1.1 404 Not Found");
                $details['heading'] = 'Page not found';
                break;
            case 403:
                header("HTTP/1.1 403 Forbidden");
                $details['heading'] = 'Forbidden';
                break;
            case 405;
                header("HTTP/1.1 405 Method Not Allowed");
                $details['heading'] = 'Method not allowed';
                break;
            case 500:
                header("HTTP/1.1 422 Internal Server Error");
                $details['heading'] = 'Server error';
                break;
            default:
                break;
        }

        $this->container['basic_view_builder']->renderWithTemplate($details, 'error_details', 'demo/error.html.twig');
        exit;
    }
}
