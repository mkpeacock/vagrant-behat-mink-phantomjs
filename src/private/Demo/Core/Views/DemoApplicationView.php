<?php
namespace Demo\Core\Views;

class DemoApplicationView implements \CentralApps\Base\Views\ApplicationViewInterface
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function preParseHook(\CentralApps\Base\Views\TemplateEngineInterface $template_engine_adapter)
    {

        $this->container['template_variables']['current_user'] = $this->container['current_user'];

        if (isset($_SESSION['system_notification'])) {
            $this->container['template_variables']['system_notification'] = $_SESSION['system_notification'];
            $this->container['template_variables']['system_notification_class'] = $_SESSION['system_notification_class'];
            $this->container['template_variables']['system_notification_code'] = $_SESSION['system_notification_code'];

            unset($_SESSION['system_notification']);
            unset($_SESSION['system_notification_class']);
            unset($_SESSION['system_notification_code']);

        }

        $this->container['template_variables']['application_environment'] = $this->container['settings']['main']['environment'];
    }
}
