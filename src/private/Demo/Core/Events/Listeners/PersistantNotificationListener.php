<?php
namespace Demo\Core\Events\Listeners;

class PersistantNotificationListener
{
    protected $container;
    protected $eventMessageMapping = array(
        'login.failed' => array('notification_type' => 'error',
                                    'notification_message' => 'Sorry, the login details you supplied were not valid',
                                    'notification_code' => 'A0001'),
        'user.logged_out' => array('notification_type' => 'success',
                                    'notification_message' => 'You have been logged out',
                                    'notification_code' => 'A0002'),
    );

    public function __construct($container)
    {
        $this->container = $container;

    }

    public function setNotification($event)
    {
        if (array_key_exists($event->getName(), $this->eventMessageMapping)) {
            $message_data = $this->eventMessageMapping[$event->getName()];
            $_SESSION['system_notification'] = $message_data['notification_message'];
            $_SESSION['system_notification_class'] = $message_data['notification_type'];
            $_SESSION['system_notification_code'] = $message_data['notification_code'];
        }
    }
}
