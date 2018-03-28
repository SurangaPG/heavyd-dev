@api @d8 @javascript
Feature: Check the visibility of the toolbar.

  Scenario: As an anymous user I should not see the toolbar.
    Given I am on the homepage
    Then I should not see the toolbar

  Scenario: As an authenticated user I should not see the toolbar.
    Given I am logged in as a user with the "authenticated" role
    Given I am on the homepage
    Then I should not see the toolbar

  # @TODO, Remove the manage tab for editors.
  Scenario: As a webmaster I should see the toolbar.
    Given I am logged in as a user with the "webmaster, editor" role
    Given I am on the homepage
    Then I should see the toolbar
    And the toolbar should contain:
      | Content |
      | Manage  |

  # @TODO, Remove the manage tab for editors.
  Scenario: As an editor I should see the toolbar.
    Given I am logged in as a user with the "editor" role
    Given I am on the homepage
    Then I should see the toolbar
    And the toolbar should contain:
      | Content |
      | Manage  |

  Scenario: As an administrator I should see the toolbar.
    Given I am logged in as a user with the "administrator" role
    Given I am on the homepage
    Then I should see the toolbar
    And the toolbar should contain:
      | Content    |
      | Manage     |
      | Shortcuts  |

