<?php
namespace Demo\Content\Views;

class ViewContent extends \Demo\Core\Views\AbstractView
{
    public function render($model=null, $model_name=null)
    {
        parent::preRender($model, $model_name);
        $this->container['template_variables']['content'] = $model;
        $this->prepare();
        $this->templateEngineAdapter->useTemplate('demo/content/view.html.twig');
        echo $this->templateEngineAdapter->getOutput();
        exit;

    }
}
