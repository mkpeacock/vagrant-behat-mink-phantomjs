<?php
namespace Demo\Core\Events\Listeners;

class AuthenticationListener
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function loginUser($event)
    {
        $user = $event->getPayload();
        $this->container['authentication_processor']->manualLogin($user->getUsername(), $user->getRawPassword());
    }
}
