<?php
namespace Demo\Content\Validation;

use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;

class ContentValidationRules
{
    use \Demo\Core\DebugTrait;

    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
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
            'content_heading' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 2, 'max' => 255))),
            'content_content' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 2))),
        );
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
