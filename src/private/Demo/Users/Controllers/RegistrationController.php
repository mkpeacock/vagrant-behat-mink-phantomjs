<?php
namespace Demo\Users\Controllers;

class RegistrationController extends \Demo\Core\Controllers\AbstractController
{
    protected $formHelper = null;

    public function registrationPage()
    {
        $this->model->formHelper = $this->formHelper;
        $this->container['view_builder']('\Demo\Users\Views\Register')->render($this->model);
    }

    public function processRegistration()
    {
        $data = $this->getRequestArrayToValidate();
        $violations = $this->container['validation_rules']['users']->getViolations($data);
        if (count($violations) > 0) {
            $this->formHelper = $this->container['form_helper_post']($data, $violations);
            $this->registrationPage();
        } else {
            $user = $this->createUser($data);
            $standard_event = $this->container['standard_event']($user);
            $this->container['dispatcher']->dispatch('user.registered', $standard_event);
        }
    }

    protected function createUser($request_data)
    {
        $user = $this->container['factories']['users']->createNewUser();
        $user->setName($request_data['user_name']);
        $user->setEmail($request_data['user_email']);
        $user->setUsername($request_data['user_username']);
        $user->hashAndSetPassword($request_data['user_password']);
        $user->save();

        return $user;
    }
}
