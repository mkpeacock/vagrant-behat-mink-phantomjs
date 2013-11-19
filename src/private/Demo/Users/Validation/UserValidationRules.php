<?php
namespace Demo\Users\Validation;

use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;

class UserValidationRules
{
    use \Demo\Core\DebugTrait;

    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function setEditing($editing)
    {
        $this->editing = $editing;
    }

    public function setRelatedUser($user)
    {
        $this->relatedUser = $user;
    }

    public function getConstraint($input)
    {
        return new Assert\Collection($this->getConstraintArray());
    }

    public function getConstraintArray()
    {
        $container = $this->container;
        $related_user = $this->relatedUser;

        $constraints = array(
            'user_name' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 2, 'max' => 100))),
            'user_username' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 2, 'max' => 100)), new Assert\Callback(array('methods' => array(function($entity, $context) use ($container, $related_user) {
                $data = $context->getRoot();
                $users = $container['factories']['users']->getFromUsername($data['user_username']);
                if (count($users) > 0) {
                    if ($this->editing && count($users) == 1) {
                        $user = $users->pop();
                        if ($user->getId() != $related_user->getId()) {
                            $context->addViolation('Sorry, that username is already taken');
                        }
                    } else {
                        $context->addViolation('Sorry, that username is already taken');
                    }
                }
            })))),
            'user_email' => array(new Assert\NotBlank(), new Assert\Email(), new Assert\Callback(array('methods' => array(function($entity, $context) use ($container, $related_user) {
                $data = $context->getRoot();
                $users = $container['factories']['users']->getFromEmail($data['user_email']);
                if (count($users) > 0) {
                    if ($this->editing && count($users) == 1) {
                        $user = $users->pop();
                        if ($user->getId() != $related_user->getId()) {
                            $context->addViolation('Sorry, a user with that email address is already registered');
                        }
                    } else {
                        $context->addViolation('Sorry, a user with that email address is already registered');
                    }
                }
            }))))
        );

        $user_password_constraint = array();
        $user_password_confirm_constraint = array();

        if (false == $this->editing) {
            $user_password_constraint[] = new Assert\NotBlank();
            $user_password_confirm_constraint[] = new Assert\NotBlank();
        }
        $editing = $this->editing;

        $user_password_constraint[] = new Assert\Callback(array('methods' => array(
            function($entity, $context) use ($editing) {
                $data = $context->getRoot();
                $confirm = (isset($data['user_password_confirm'])) ? $data['user_password_confirm'] : '';
                if (!($editing && '' == $data && '' == $confirm)) {
                    if ($entity != $confirm) {
                        $context->addViolation('Your password and confirmation must be the same', array(), null);
                    }
                }
            }
        )));

        $user_password_constraint[] = new Assert\Length(array('min' => 5));
        $user_password_confirm_constraint[] = new Assert\Length(array('min' => 5));

        $constraints['user_password'] = $user_password_constraint;
        $constraints['user_password_confirm'] = $user_password_confirm_constraint;

        return $constraints;
    }

    public function getValidator()
    {
        return Validation::createValidator();
    }

    public function getViolations($input)
    {
        $violations = $this->getValidator()->validateValue($input, $this->getConstraint($input));

        return $violations;
    }
}
