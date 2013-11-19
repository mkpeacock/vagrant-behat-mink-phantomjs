<?php
namespace Demo\Core\Containers;

class ValidationContainer extends \Pimple
{
    public function __construct(array $values = array())
    {
        parent::__construct($values);

        $this['users'] = $this->share(function($c) {
            return new \Demo\Users\Validation\UserValidationRules($c['container']);
        });

        $this['content'] = $this->share(function($c) {
            return new \Demo\Content\Validation\ContentValidationRules($c['container']);
        });

    }
}
