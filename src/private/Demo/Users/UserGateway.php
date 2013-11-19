<?php
namespace Demo\Users;

class UserGateway extends \CentralApps\Authentication\UserGateway
{
    use \Demo\Core\DebugTrait;

    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
        $this->userIdCookieName = $this->container['settings']['authentication']['providers']['cookie']['user_id_cookie_name'];
        $this->userIdCookieName = $this->container['settings']['authentication']['providers']['cookie']['user_hash_cookie_name'];
    }

}
