<?php
namespace Demo\Users\DataAccess;

abstract class UserModel extends \CentralApps\Dao\AbstractMethodBasedModel
{
    protected $daoContainerKey = 'users';
}
