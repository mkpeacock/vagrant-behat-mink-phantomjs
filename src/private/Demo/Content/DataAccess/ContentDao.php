<?php
namespace Demo\Content\DataAccess;

class ContentDao extends \CentralApps\Dao\AbstractPdoDao
{
    protected $tableName = 'content';
    protected $databaseEngineReference = 'pdo_mysql';
    protected $fields = array(
        'id' => \PDO::PARAM_INT,
        'heading' => \PDO::PARAM_STR,
        'content' => \PDO::PARAM_STR
    );
}
