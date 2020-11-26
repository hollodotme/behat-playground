Feature: Login
  In order to view my orders
  As a customer
  I need to be able to log into my account

  Rules:
  - 3 Login attempts maximum
  - Login is disabled for 1 hour, if it failed 3 times

  Scenario: Login succeeds
    Given there is a user with username "KeanuReeves" and password "Hollywood2020"
    When I enter the username "KeanuReeves" to the user input field
    And I enter the password "Hollywood2020" to the password input field
    Then I should have logged in successfully

  Scenario: Login fails
    Given there is a user with username "KeanuReeves" and password "Hollywood2020"
    When I enter the username "KeanuReeves" to the user input field
    And I enter the password "Hollywood2021" to the password input field
    Then The login should fail
