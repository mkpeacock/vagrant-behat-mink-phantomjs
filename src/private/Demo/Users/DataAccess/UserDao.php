<?php
namespace Demo\Users\DataAccess;

class UserDao extends \CentralApps\Dao\AbstractPdoDao
{
    protected $tableName = 'users';
    protected $databaseEngineReference = 'pdo_mysql';
    protected $fields = array(
        'id' => \PDO::PARAM_INT,
        'name' => \PDO::PARAM_STR,
        'username' => \PDO::PARAM_STR,
        'email' => \PDO::PARAM_STR,
        'password' => \PDO::PARAM_STR
    );
}
