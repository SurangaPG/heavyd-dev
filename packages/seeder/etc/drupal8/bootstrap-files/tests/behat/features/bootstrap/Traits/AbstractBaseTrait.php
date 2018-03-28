<?php

namespace DrupalProject\Behat\Traits;

/**
 * Class AbstractBaseTrait
 *
 * Contains helpers to check or all the items contains the exact amount of
 * pieces of text.
 */
trait AbstractBaseTrait {

  /**
   * Spoof this method to allow for cleaner code autocomplete.
   *
   * @param string|null $name
   *   The name for the session to get.
   *
   * @return \Behat\Mink\Session
   *   The mink session currently running.
   */
  abstract public function getSession($name = NULL);
}