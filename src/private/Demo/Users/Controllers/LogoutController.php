<?php
namespace Demo\Users\Controllers;

class LogoutController extends \Demo\Core\Controllers\AbstractController
{
    public function logout()
    {
        $this->container['authentication_processor']->logout();
        $this->container['dispatcher']->dispatch('user.logged_out', $this->container['standard_event']($this->container['current_user']));
    }
}
