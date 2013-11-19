<?php
namespace Demo\Users\Controllers;

class LoginController extends \Demo\Core\Controllers\AbstractController
{
    public function loginForm()
    {
        $this->container['view_builder']('\Demo\Users\Views\Login')->render($this->model);
    }
}
