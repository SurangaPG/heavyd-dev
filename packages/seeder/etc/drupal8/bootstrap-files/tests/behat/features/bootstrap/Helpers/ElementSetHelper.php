<?php

namespace DrupalProject\Behat\Helpers;

use Behat\Gherkin\Node\TableNode;
use Behat\Mink\Element\DocumentElement;

/**
 * Class ElementSetHelper
 *
 * Contains helpers to check or all the items contains the exact amount of
 * pieces of text.
 */
class ElementSetHelper {

  /**
   * All the existing strings (based of the data in the elements).
   *
   * @var string[]
   *   All the existing strings.
   */
  protected $existingStrings;

  /**
   * All the expected strings.
   *
   * @var string[]
   *   All the expected strings.
   */
  protected $expectedStrings;

  /**
   * The node elements.
   *
   * @var \Behat\Mink\Element\NodeElement[]
   *   The nods elements.
   */
  protected $elements;

  /**
   * @param string $selector
   *   The selector to use.
   * @param \Behat\Gherkin\Node\TableNode $expectedData
   *   Table node with singular text data to use.
   * @param string $selectorType
   *   Selector type, defaults to css.
   * @param \Behat\Mink\Element\DocumentElement $document
   *   Document to get the set from.
   *
   * @return \DrupalProject\Behat\Helpers\ElementSetHelper
   *   A new helper with some data preloaded.
   */
  public static function createSetHelperFromSelectorAndTableNode(string $selector, TableNode $expectedData, DocumentElement $document, $selectorType = 'css') {
    $extractedExpectations = [];
    foreach ($expectedData->getRows() as $row) {
      $extractedExpectations[] = reset($row);
    }
    $extractedExpectations = array_filter($extractedExpectations);

    $elements = $document->findAll($selectorType, $selector);
    $elements = isset($elements) ? $elements : [];

    return new static($elements, $extractedExpectations);
  }

  /**
   * ElementSetHelper constructor.
   *
   * @param |Behat\Mink\Element\NodeElement[] $elements
   *   Elements to look for the text in.
   * @param string[] $expectations
   *   Actual expectations.
   */
  public function __construct(array $elements, array $expectations) {
    $this->elements = $elements;
    $this->expectedStrings = $expectations;
  }

  /**
   * Extract the text from the node items.
   *
   * @param bool $force
   *   Force the rewriting of the already found texts.
   */
  public function extractExistingText($force = FALSE) {
    if (!isset($this->existingStrings) || $force) {
      $this->existingStrings = [];
      foreach ($this->elements as $element) {
        $this->existingStrings[] = $element->getText();
      }
      $this->existingStrings = array_filter($this->existingStrings);
    }
  }

  /**
   * Check that the expected values are exact to those in the items.
   *
   * @return bool
   *   Flag indicating the values are exact.
   */
  public function checkValuesAreExact() {
    return empty($this->existingNotExpected()) && empty($this->expectedNotExisting());
  }

  /**
   * Check that all the values are present.
   *
   * @return bool
   *   Flag indicating the values are all present.
   */
  public function checkValuesAreAllPresent() {
    return empty($this->expectedNotExisting());
  }

  /**
   * @return array
   *   All the existing items that were not expected.
   */
  public function existingNotExpected() {
    return array_diff($this->getExistingStrings(), $this->getExpectedStrings());
  }

  /**
   * @return array
   *   All the expected items that did not exist.
   */
  public function expectedNotExisting() {
    return array_diff($this->getExpectedStrings(), $this->getExistingStrings());
  }

  /**
   * Get all the elements
   *
   * @return array|\Behat\Mink\Element\NodeElement[]
   *   All the relevant elements.
   */
  public function getElements() {
    return $this->elements;
  }

  /**
   * Get the existing strings.
   *
   * @return \string[]
   *   All the existing strings in the elements.
   */
  public function getExistingStrings() {
    if (!isset($this->existingStrings)) {
      $this->extractExistingText();
    }
    return $this->existingStrings;
  }

  /**
   * Get the expected strings.
   *
   * @return array|\string[]
   *   All the expected strings from the requirements.
   */
  public function getExpectedStrings() {
    return $this->expectedStrings;
  }
}

