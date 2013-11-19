<?php
namespace Demo\Core\Containers;

class FactoriesContainer extends \Pimple
{
    public function __construct(array $values = array())
    {
        parent::__construct($values);

        $this['users'] = $this->share(function($c) {
            return new \Demo\Users\DataAccess\UserFactory($c['container']);
        });

        $this['content'] = $this->share(function($c) {
            return new \Demo\Content\DataAccess\ContentFactory($c['container']);
        });
    }
}
