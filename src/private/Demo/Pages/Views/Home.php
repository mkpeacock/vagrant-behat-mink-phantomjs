<?php
namespace Demo\Pages\Views;

class Home extends \Demo\Core\Views\AbstractView
{
    public function render($model=null, $model_name=null)
    {
        parent::preRender($model, $model_name);
        $this->prepare();
        $this->templateEngineAdapter->useTemplate('demo/home.html.twig');
        echo $this->templateEngineAdapter->getOutput();
        exit;

    }
}
