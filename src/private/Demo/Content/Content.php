<?php
namespace Demo\Content;

class Content extends DataAccess\ContentModel
{
    protected $id;
    protected $heading;
    protected $content;

    public function getId()
    {
        return $this->id;
    }

    public function getHeading()
    {
        return $this->heading;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setHeading($heading)
    {
        $this->heading = $heading;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

}
