<?php
namespace Demo\Content\DataAccess;

class ContentFactory extends \Demo\Core\DataAccess\AbstractFactory
{
    use \Demo\Core\DebugTrait;

    protected $container;
    protected $modelClass = '\Demo\Content\Content';

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function createNewContent()
    {
        return new \Demo\Content\Content($this->container);
    }

    public function getFromId($id)
    {
        $sql = "SELECT
                    c.*
                FROM
                    content c
                WHERE
                    c.id = :id
                ORDER BY
                    c.id ASC";

        $statement = $this->container['pdo_mysql']->prepare($sql);
        $statement->bindParam(':id', $id, \PDO::PARAM_INT);

        return $this->buildFromPdoStatement($statement);
    }
}
