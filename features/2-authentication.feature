Feature: Authentication

    Scenario: Logging in
        Given I am on "/login"
        And I fill in "login_username" with "mkpeacock10"
        And I fill in "login_password" with "password"
        And I press "Login"
        Then I should see "Welcome Michael"

    Scenario: Logout
        Given I am on "/login"
        And I fill in "login_username" with "mkpeacock10"
        And I fill in "login_password" with "password"
        And I press "Login"
        Then I should see "Welcome Michael"
        Given I am on "/logout"
        Then I should see "login"

    Scenario: Better logout
        Given I am logged in with the username "mkpeacock10" and password "password"
        And I am on "/logout"
        Then I should see "login"

    Scenario: Better login
        Given A user exists with the username "mkpeacock0001" and password "password"
        And I am logged in with the username "mkpeacock0001" and password "password"
        Then I should see "Welcome"
