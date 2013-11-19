<?php
namespace Demo\Users\DataAccess;

class UserFactory extends \Demo\Core\DataAccess\AbstractFactory implements \CentralApps\Authentication\UserFactoryInterface
{
    use \Demo\Core\DebugTrait;

    protected $container;
    protected $modelClass = '\Demo\Users\User';

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function createNewUser()
    {
        return new \Demo\Users\User($this->container);
    }

    public function getFromId($id)
    {
        $sql = "SELECT
                    u.*
                FROM
                    users u
                WHERE
                    u.id = :id
                ORDER BY
                    u.id ASC";

        $statement = $this->container['pdo_mysql']->prepare($sql);
        $statement->bindParam(':id', $id, \PDO::PARAM_INT);

        return $this->buildFromPdoStatement($statement);
    }

    public function getFromUsername($username)
    {
        $sql = "SELECT
                    u.*
                FROM
                    users u
                WHERE
                    u.username = :username
                ORDER BY
                    u.id ASC";

        $statement = $this->container['pdo_mysql']->prepare($sql);
        $statement->bindParam(':username', $username, \PDO::PARAM_STR);

        return $this->buildFromPdoStatement($statement);
    }

    public function getFromEmail($email)
    {
        $sql = "SELECT
                    u.*
                FROM
                    users u
                WHERE
                    u.email = :email
                ORDER BY
                    u.id ASC";

        $statement = $this->container['pdo_mysql']->prepare($sql);
        $statement->bindParam(':email', $email, \PDO::PARAM_STR);

        return $this->buildFromPdoStatement($statement);
    }

    public function getUserFromUsernameAndPassword($username, $password)
    {
        // NOTE: returns either single model, OR throws exception, to conform with authentication expectations
        $sql = "SELECT * FROM
                users
            WHERE
                username = :username
            AND
                password = SHA1(CONCAT(SHA1(id), SHA1(:password)))
            LIMIT
                1";

        $statement = $this->container['pdo_mysql']->prepare($sql);

        $statement->bindParam(':username', $username);
        $statement->bindParam(':password', $password);

        $users = $this->buildFromPdoStatement($statement);
        if (1 == count($users)) {
            return $users->pop();
        }
        throw new \Exception("User not found");
    }

    public function getByCookieValues($cookie_values)
    {
        throw new \LogicException("Not implemented");
    }

    public function getUserByUserId($user_id)
    {
        // NOTE: returns either single model, OR throws exception, to conform with authentication expectations
        $sql = "SELECT * FROM
                users
            WHERE
                id = :id
            LIMIT
                1";
        $statement = $this->container['pdo_mysql']->prepare($sql);
        $statement->bindParam(':id', $user_id, \PDO::PARAM_INT);
        $users = $this->buildFromPdoStatement($statement);
        if (1 == count($users)) {
                return $users->pop();
        }
        throw new \Exception("User not found");
    }
}
