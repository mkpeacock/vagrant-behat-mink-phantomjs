<?php
namespace Demo\Pages\Controllers;

class StaticPagesController extends \Demo\Core\Controllers\AbstractController
{
    public function viewHomePage()
    {
        $this->container['view_builder']('\Demo\Pages\Views\Home')->render($this->model);
    }
}
