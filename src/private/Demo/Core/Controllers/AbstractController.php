<?php
namespace Demo\Core\Controllers;

class AbstractController extends \CentralApps\Base\AbstractController
{
    use \Demo\Core\DebugTrait;

    protected $request;
    protected $requestArray = null;
    protected $model;

    public function __construct($container)
    {
        parent::__construct($container);
        $this->populateRequest();
        $this->model = new \stdClass();
    }

    protected function populateRequest()
    {
        $this->request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();
    }

    protected function getRequestArrayToValidate()
    {
        if (is_null($this->requestArray)) {
            $this->requestArray = array_merge($this->request->request->all(), $this->request->files->all());
        }

        return $this->requestArray;
    }
}
