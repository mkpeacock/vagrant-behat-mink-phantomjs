<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Features context.
 */
class FeatureContext extends \Behat\MinkExtension\Context\MinkContext
{
    protected static $container = null;
    protected static $usersToDelete = array();

    /**
     * Initializes context.
     * Every scenario gets its own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
        if (is_null(self::$container)) {
            require_once(__DIR__.'/../../src/private/bootstrap.php');
            self::$container = $application->getContainer();
        }
    }

    /**
     * @Given /I am logged in with the username "([^"]*)" and password "([^"]*)"/
     */
    public function loginWithEmailAndPassword($username, $password)
    {
        //$this->ensureUserExistsWithEmailAndPassword($email, $password);

        return array(
            new Behat\Behat\Context\Step\Given("I am on \"/login\""),
            new Behat\Behat\Context\Step\When("I fill in \"login_username\" with \"$username\""),
            new Behat\Behat\Context\Step\When("I fill in \"login_password\" with \"$password\""),
            new Behat\Behat\Context\Step\When("I press \"Login\""),
            new Behat\Behat\Context\Step\Then("I should see \"Welcome\"")
        );
    }

    /**
     * @Given /A user exists with the username "([^"]*)" and password "([^"]*)"/
     */
    public function ensureUserExistsWithUsernameAndPassword($username, $password)
    {
        $factory = self::$container['factories']['users'];
        $users = $factory->getFromUsername($username);
        if (1 == count($users)) {
            $user = $users->pop();
            if ($user->getPassword() != sha1(sha1($user->getId()) . sha1($password))) {
                $user->hashAndSetPassword($password);
            }
        } else {
            $user = $factory->createNewUser();
            $user->setUsername($username);
            $user->setEmail(time() . '@gmail.com');
            $user->hashAndSetPassword($password);
            $user->save();
            self::$usersToDelete[] = $username;
        }
    }


    /** @AfterFeature */
    public static function tearDownRegisterFeature(\Behat\Behat\Event\FeatureEvent $event)
    {
        //if ('Register' == $event->getFeature()->getTitle()) {

        $factory = self::$container['factories']['users'];
        foreach (self::$usersToDelete as $username) {
            $users = $factory->getFromUsername($username);
            if (1 == count($users)) {
                $user = $users->pop();
                $user->delete();
            }
        }
    }

}
