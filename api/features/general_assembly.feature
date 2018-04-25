# This file contains a user story for demonstration only.
# Learn how to get started with Behat and BDD on Behat's website:
# http://behat.org/en/latest/quick_start.html

Feature:
  Manage General Assembly

  Scenario: I create a General Assembly
    Given I add "Accept" header equal to "application/ld+json"
    Given I add "Content-Type" header equal to "application/ld+json"
    When I send a "POST" request to "/general_assemblies" with body:
    """
    {
      "date": "2018-05-14T22:00:00.000Z"
    }
    """
    Then the response status code should be 201
    And the JSON node "@context" should be equal to "/contexts/GeneralAssembly"
    And the JSON node "@type" should be equal to "GeneralAssembly"
    And the JSON node "date" should be equal to "14/05/2018"
    And the JSON node "name" should be equal to "Assemblée générale du 14/05/2018"

  Scenario: I should not be able to create two General Assemblies with the same date
    Given I add "Accept" header equal to "application/ld+json"
    Given I add "Content-Type" header equal to "application/ld+json"
    When I send a "POST" request to "/general_assemblies" with body:
    """
    {
      "date": "2018-05-14T22:00:00.000Z"
    }
    """
    And I add "Accept" header equal to "application/ld+json"
    And I add "Content-Type" header equal to "application/ld+json"
    And I send a "POST" request to "/general_assemblies" with body:
    """
    {
      "date": "2018-05-14T22:00:00.000Z"
    }
    """
    Then the response should be in JSON
    And the response status code should be 400
    And the JSON node "@context" should be equal to "/contexts/ConstraintViolationList"
    And the JSON node "@type" should be equal to "ConstraintViolationList"