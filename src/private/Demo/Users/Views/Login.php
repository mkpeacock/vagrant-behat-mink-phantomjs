<?php
namespace Demo\Users\Views;

class Login extends \Demo\Core\Views\AbstractView
{
    public function render($model=null, $model_name=null)
    {
        parent::preRender($model, $model_name);
        $this->prepare();
        $this->templateEngineAdapter->useTemplate('demo/login.html.twig');
        echo $this->templateEngineAdapter->getOutput();
        exit;

    }
}
