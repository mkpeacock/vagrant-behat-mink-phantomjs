<?php
namespace Demo\Core\DataAccess;

abstract class AbstractFactory
{
    protected $container;
    protected $modelClass = null;

    public function __construct($container)
    {
        $this->container = $container;

        if (is_null($this->modelClass)) {
            throw new \LogicException("Factory instantiated without a model class reference");
        }
    }

    protected function buildFromPdoStatement(\PdoStatement $statement)
    {
        $collection = $this->getCollection();
        $statement->execute();
        while ($row = $statement->fetch(\PDO::FETCH_ASSOC)) {
            $model = new $this->modelClass($this->container);
            $model->hydrate($row);
            $collection->add($model);
        }

        return $collection;
    }

    protected function getCollection()
    {
        // Created this method, so sub-classes can use their own collections if they wish
        $collection = $this->container['collection']();
        return $collection;
    }
}
