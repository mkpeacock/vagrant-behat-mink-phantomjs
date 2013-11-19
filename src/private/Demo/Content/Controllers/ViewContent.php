<?php
namespace Demo\Content\Controllers;

class ViewContent extends \Demo\Core\Controllers\AbstractController
{
    public function viewContent($id)
    {
        $content = $this->container['factories']['content']->getFromId($id);
        if (1 == count($content)) {
            $content = $content->pop();
            $this->container['view_builder']('\Demo\Content\Views\ViewContent')->render($content);
        } else {
            echo 'error - content not found';
        }
    }
}
