Feature: Generate company emails for an employee
  As a line manager
  I want to make sure a new employee has a company email

  Scenario: Generating a company email for a new employee
    Given "Jack" has joined the company
    And the company email format is "username@mycompany.com"
    When the company email address is generated
    Then it should equal "jack@mycompany.com"
