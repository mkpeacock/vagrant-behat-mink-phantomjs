<?php
namespace Demo\Core\Views;

abstract class AbstractView extends \CentralApps\Base\Views\AbstractView
{
    protected function prepare()
    {
        $this->prepareApplicationView();
        $this->templateEngineAdapter->useVariables($this->container['template_variables']->getVariables());
    }

    public function generate($model=null, $model_name=null)
    {
        // TODO: complete method implementation?
        $this->prepare();
    }

    protected function preRender($model = null, $model_name = null)
    {
        if (isset($this->container['api_context']) && true == $this->container['api_context']) {
            echo json_encode($model);
            exit;
        }
    }

}
