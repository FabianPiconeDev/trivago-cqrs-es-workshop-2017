Feature: Check in
  In order to check in
  As a guest
  I need to be able to check in into a building

  Rules:
  - Guest should not be already checked in

  Scenario: Check in as non checked in user
    Given there is a building
    And guest named "fabian" is not checked in
    When guest with name "fabian" checks in
    Then building must have one checked-in user named "fabian"

  Scenario: Check in as already checked in user
    Given there is a building
    And guest named "fabian" is already checked in
    When guest with name "fabian" checks in
    Then system must throw an exception that guest is already checked in
    And building must have one checked-in user named "fabian"