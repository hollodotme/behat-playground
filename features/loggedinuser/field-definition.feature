Feature: Toggle lock on object field values for users
  As a logged in user
  I need to be able to toggle a lock on object field values
  in order to ommit/allow manual edits

  Rules:
    - All other fields remain in their locking state
    - If a field was locked and a default value was set, it should be used for new objects
    - If a field was locked and no default value was set, new objects should have an undefined value (NULL)
    - Existing objects will continue to use their field values regardless of their locking state
    - Object field values can be set by newly imported objects regardless of their locking state
    - If there is an input value for a locked object field, the input value should be ignored

  Scenario: Lock an object field value
    Given there is an object "Chair" with manufacturer "IKEA" and color "white"
    When I lock the field value for "color" and set its default value to "black"
    And the user "susann" adds an object "Table" with manufacturer "IKEA" and color "white"
    Then I can still edit the field "manufacturer"
    And the object "Chair" has the color "white"
    And the object "Table" has the color "black"

  Scenario: Lock an object field value
    Given there is an object "Chair" with manufacturer "IKEA" and color "white"
    When I lock the field value for "color" and set its default value to "black"
    And the user "import" adds an object "Table" with manufacturer "IKEA" and color "white"
    Then I can still edit the field "manufacturer"
    And the object "Chair" has the color "white"
    And the object "Table" has the color "white"
