<?php
namespace Demo\Core\Controllers;

class ErrorController extends \CentralApps\Base\AbstractController
{
    public function viewErrorPage($status_code, $heading = null, $content = null)
    {
        // TODO: dispatch error
        http_response_code($status_code);
        // render template
        echo $this->container['twig']->render('demo/errors/' . $status_code . '.html.twig', array('heading' => $heading, 'content' => $content, 'status_code' => $status_code));
    }

    public function requiresLogin()
    {
        // TODO: post login redirection

        $accessing_via_api = false;
        if (true == $accessing_via_api) {
            $this->viewErrorPage(401);
        } else {
            echo $this->container['twig']->render('demo/login.html.twig');
        }
    }
}
