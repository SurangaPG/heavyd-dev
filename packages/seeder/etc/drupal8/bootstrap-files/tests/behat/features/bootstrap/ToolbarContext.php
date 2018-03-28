<?php


/**
 * @file
 * Contains extra context for workflow based items.
 *
 * Which is a helper to validate and check various organic group related things.
 * Such as the id for a group etc.
 */
namespace DrupalProject\Behat;

use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\TableNode;
use Behat\Mink\Exception\ExpectationException;
use Drupal\DrupalExtension\Context\RawDrupalContext;
use DrupalProject\Behat\Helpers\ElementSetHelper;

/**
 * Defines generic step definitions.
 */
class ToolbarContext extends RawDrupalContext implements SnippetAcceptingContext {

  /**
   * @var array
   *   All the mappings for the toolbar identifiers.
   */
  public $mappings = [
    'admin_toolbar' => '#toolbar-administration',
    'admin_toolbar_main_tab' => '#toolbar-administration .toolbar-tab > a',
  ];

  /**
   * @Then I should not see the toolbar
   */
  public function iShouldNotSeeTheToolbar()
  {
    $toolbar = $this->getSession()->getPage()->find('css', $this->getIdentifier('admin_toolbar'));

    if (isset($toolbar)) {
      new ExpectationException('The toolbar should not have been visible', $this->getSession()->getDriver());
    }
  }

  /**
   * @Then I should see the toolbar
   */
  public function iShouldSeeTheToolbar()
  {
    $toolbar = $this->getSession()->getPage()->find('css', $this->getIdentifier('admin_toolbar'));

    if (!isset($toolbar)) {
      new ExpectationException('The toolbar should have been visible', $this->getSession()->getDriver());
    }
  }

  /**
   * @Then the toolbar should contain:
   */
  public function theToolbarShouldContain(TableNode $expectedTabs)
  {
    $tabHelper = ElementSetHelper::createSetHelperFromSelectorAndTableNode(
      $this->getIdentifier('admin_toolbar_main_tab'),
      $expectedTabs,
      $this->getSession()->getPage()
    );

    // One item is always expected to be the current user.
    // @TODO Make this more stable.
    $existingNotExpected = $tabHelper->existingNotExpected();
    if (count($existingNotExpected) > 1) {
      throw new ExpectationException(
        sprintf(
          'Only expected the provided tabs and a user tab, also found: %s',
          implode(', ', $existingNotExpected)
        ),
        $this->getSession()->getDriver()
      );
    }

    if (!$tabHelper->checkValuesAreAllPresent()) {
      throw new ExpectationException(
        sprintf(
          'The following tabs were expected but could not be found: %s',
          implode(', ', $tabHelper->expectedNotExisting())
        ),
        $this->getSession()->getDriver()
      );
    }
  }

  /**
   * Get an identifier based on the mapping.
   *
   * @param string $machineName
   *   Machine name for the identifier
   *
   * @return string
   *   Identifier for the item.
   *
   * @throws \Exception
   *   If the identifier wasn't mapped on a machineName.
   */
  protected function getIdentifier(string $machineName) {
    if (!isset($this->mappings[$machineName])) {
      throw new \Exception(sprintf('selector for "%s" not found'));
    }

    return $this->mappings[$machineName];
  }
}

