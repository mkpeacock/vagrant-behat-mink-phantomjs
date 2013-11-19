<?php
namespace Demo\Content\Controllers;

class ManageContent extends \Demo\Core\Controllers\AbstractController
{
    public function createContentForm()
    {
        $this->model->formHelper = $this->formHelper;
        $this->container['view_builder']('\Demo\Content\Views\CreateEditContent')->render($this->model);
    }

    public function createContent()
    {
        $data = $this->getRequestArrayToValidate();
        $violations = $this->container['validation_rules']['content']->getViolations($data);
        if (count($violations) > 0) {
            $this->formHelper = $this->container['form_helper_post']($data, $violations);
            $this->createContentForm();
        } else {
            $content = $this->insertContent($data);
            $standard_event = $this->container['standard_event']($content);
            $this->container['dispatcher']->dispatch('content.created', $standard_event);
        }
    }

    protected function insertContent($data)
    {
        $content = $this->container['factories']['content']->createNewContent();
        $content->setHeading($data['content_heading']);
        $content->setContent($data['content_content']);
        $content->save();

        return $content;
    }
}
