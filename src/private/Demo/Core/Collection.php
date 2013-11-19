<?php
namespace Demo\Core;

class Collection extends \CentralApps\Core\AbstractCollection implements \jsonSerializable
{
    public function jsonSerialize()
    {
        return $this->objects;
    }
}
