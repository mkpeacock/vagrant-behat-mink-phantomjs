<?php
namespace Demo\Users;

class User extends DataAccess\UserModel
{
    protected $id;
    protected $name;
    protected $username;
    protected $email;
    protected $password;

    protected $rawPassword; // does not persist

    public function hashAndSetPassword($password)
    {
        $this->save(); // need to do this to get an ID if its new!
        $this->setRawPassword($password);
        $password = sha1(sha1($this->id) . sha1($password));
        $this->setPassword($password);
        $this->save();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getRawPassword()
    {
        return $this->rawPassword;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setRawPassword($raw)
    {
        $this->rawPassword = $raw;
    }
}
