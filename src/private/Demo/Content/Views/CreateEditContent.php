<?php
namespace Demo\Content\Views;

class CreateEditContent extends \Demo\Core\Views\AbstractView
{
    public function render($model=null, $model_name=null)
    {
        parent::preRender($model, $model_name);
        $this->container['template_variables']['form_helper'] = $model->formHelper;
        $this->prepare();
        $this->templateEngineAdapter->useTemplate('demo/content/create.html.twig');
        echo $this->templateEngineAdapter->getOutput();
        exit;

    }
}
