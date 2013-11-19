<?php
namespace Demo\Core\Events\Listeners;

class RedirectionListener
{
    protected $container;
    protected $eventRedirectionMapping = array();

    public function __construct($container)
    {
        $this->container = $container;

        $this->eventRedirectionMapping['login.failed'] = array(
            'http_code' => 200,
            'redirect' => function($standard_event) use ($container) {
                return $container['router.url_generator']->generate('login_form', array());
            }
        );

        $this->eventRedirectionMapping['user.logged_out'] = array(
            'http_code' => 200,
            'redirect' => function($standard_event) use ($container) {
                return $container['router.url_generator']->generate('login_form', array());
            }
        );

        $this->eventRedirectionMapping['content.created'] = array(
            'http_code' => 200,
            'redirect' => function($standard_event) use ($container) {
                $content = $standard_event->getPayload();
                return $container['router.url_generator']->generate('content_view', array('id' => $content->getId()));
            }
        );

    }

    public function redirect($event)
    {
        if (array_key_exists($event->getName(), $this->eventRedirectionMapping)) {
            if (array_key_exists('http_status_header', $this->eventRedirectionMapping[$event->getName()])) {
                header($this->eventRedirectionMapping[$event->getName()]['http_status_header']);
            }

            header("Location: " . $this->eventRedirectionMapping[$event->getName()]['redirect']($event));
            exit;
        }
    }
}
