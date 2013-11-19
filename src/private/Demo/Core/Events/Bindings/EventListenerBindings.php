<?php
namespace Demo\Core\Events\Bindings;

class EventListenerBindings
{
    protected $defaultPriority = 10;
    protected $apiPriority = 20;
    protected $queuablePriority = 30;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function bindListeners($dispatcher)
    {
        $dispatcher = $this->bindPersistantNotificationListeners($dispatcher);
        $dispatcher = $this->bindRedirectionListeners($dispatcher);

        if (isset($this->container['api_context']) && true == $this->container['api_context']) {
            $dispatcher = $this->bindApiListeners($dispatcher);
        }

        $error_listener = new \Demo\Core\Events\Listeners\WebErrorListener($this->container);
        $dispatcher->addListener('friendly.error', array($error_listener, 'friendlyError'), $this->defaultPriority);

        $authentication_listener = new \Demo\Core\Events\Listeners\AuthenticationListener($this->container);
        $dispatcher->addListener('user.registered', array($authentication_listener, 'loginUser'), 100);

        return $dispatcher;
    }


    protected function bindPersistantNotificationListeners($dispatcher)
    {
        $notification_listener = new \Demo\Core\Events\Listeners\PersistantNotificationListener($this->container);
        $dispatcher->addListener('login.failed', array($notification_listener, 'setNotification'), 10);
        $dispatcher->addListener('user.logged_out', array($notification_listener, 'setNotification'), 10);

        return $dispatcher;
    }

    protected function bindRedirectionListeners($dispatcher)
    {
        $redirection_listener = new \Demo\Core\Events\Listeners\RedirectionListener($this->container);
        $dispatcher->addListener('login.failed', array($redirection_listener, 'redirect'), 0);
        $dispatcher->addListener('user.logged_out', array($redirection_listener, 'redirect'), 0);
        $dispatcher->addListener('content.created', array($redirection_listener, 'redirect'), 0);

        return $dispatcher;
    }

}
