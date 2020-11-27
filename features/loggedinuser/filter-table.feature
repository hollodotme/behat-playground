Feature: Filter object list by name
  As a logged in user
  I need to be able to filter the object list by name
  to check objects with the same name

  Rules:
  - Sorting of the list is preserved
  - Already applied filters remain active
  - The input text is applied case-insensitive

  Scenario Outline: Filter objects with a term
    Given there is an object with name "<objectName>"
    And there is an object with name "<objectName2>"
    When I enter "<filterTerm>" into the filter input
    Then I see 1 object in the list
    And I see the object with name "<objectName>"
    But I don't see the object with name "<objectName2>"
    Examples:
      | objectName | objectName2 | filterTerm |
      | notebook   | monitor     | ote        |
      | NOTEBOOK   | display     | ote        |
      | nOtEbOoK   | monitor     | oTe        |
      | nOtEbOoK   | monitor     | ooK        |