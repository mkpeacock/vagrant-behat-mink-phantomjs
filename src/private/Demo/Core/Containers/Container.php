<?php
namespace Demo\Core\Containers;

class Container extends \CentralApps\Base\Containers\Container
{
    public function __construct(array $values = array())
    {
        parent::__construct($values);
        $container = $this;

        $this['collection'] = $this->protect(function() {
            return new \Demo\Core\Collection();
        });

        $this['standard_event'] = $this->protect(function($payload=null) {
            return new \Demo\Core\Events\StandardEvent($payload);
        });

        $this['factories'] = $this->share(function($c){
            return new FactoriesContainer(array('container' => $c));
        });

        $this['data_access_objects'] = $this->share(function($c) {
            return new DataAccessObjectsContainer(array('container' => $c));
        });

        $this['validation_rules'] = $this->share(function($c) {
            return new ValidationContainer(array('container' => $c));
        });

        $this['user_gateway'] = $this->share(function($c) {
            return new \Demo\Users\UserGateway($c);
        });

        $this['dispatcher'] = $this->share(function($c){
            $dispatcher = new \Symfony\Component\EventDispatcher\EventDispatcher();
            $listener_binder = new \Demo\Core\Events\Bindings\EventListenerBindings($c);
            $dispatcher = $listener_binder->bindListeners($dispatcher);

            return $dispatcher;
        });

        $this['basic_view_builder'] = $this->share(function($c)  {
           $basic_view = new \Demo\Core\Views\BasicView($c, $c['template_engine_adapter'], new \Demo\Core\Views\DemoApplicationView($c));
           return $basic_view;
        });

        $this['view_builder'] = $this->protect(function($class_name) use ($container) {
            return new $class_name($container, $container['template_engine_adapter'], new \Demo\Core\Views\DemoApplicationView($container));
        });

        $this['form_helper_post'] = $this->protect(function($data=null, $errors=null) {
            $form_data = new \CentralApps\FormHelper\Data\FormData($data);
            $form_errors = new \CentralApps\FormHelper\Errors\SymfonyValidatorViolationsAdapter($errors);
            return new \CentralApps\FormHelper\FormHelper($form_data, $form_errors);
        });

        $this['form_helper_methods'] = $this->protect(function($data=null, $errors=null, $prefix='') {
            $form_data = new \CentralApps\FormHelper\Data\FormDataGetterAccess($data);
            $form_data->setPrefixToRemove($prefix);
            $form_errors = new \CentralApps\FormHelper\Errors\SymfonyValidatorViolationsAdapter($errors);
            return new \CentralApps\FormHelper\FormHelper($form_data, $form_errors);
        });

    }
}
