Feature: Create content

    Scenario: Creating content
        Given I am on "/login"
        And I fill in "login_username" with "mkpeacock10"
        And I fill in "login_password" with "password"
        And I press "Login"
        Then I should see "Welcome Michael"
        Given I follow "Create content"
        And I fill in "content_heading" with "Test heading"
        And I fill in "content_content" with "Some test content"
        And I press "Create content"
        Then I should see "Test heading"
