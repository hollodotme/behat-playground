@wip
Feature: Filter object list by name
  As a logged in user
  I need to be able to filter the object list by name
  to check objects with the same name

  Rules:
    - Sorting of the list is preserved
    - Already applied filters remain active
    - The input text is applied case-insensitive

  Scenario: Filter objects for notebook
    Given there is an object with name "notebook"
    And there is an object with name "monitor"
    When I enter "note" into the filter input
    Then I see 1 object in the list
    And I see the object with name "notebook"

  Scenario: Filter objects for NOTEBOOK
    Given there is an object with name "NOTEBOOK"
    And there is an object with name "monitor"
    When I enter "note" into the filter input
    Then I see 1 object in the list
    And I see the object with name "NOTEBOOK"