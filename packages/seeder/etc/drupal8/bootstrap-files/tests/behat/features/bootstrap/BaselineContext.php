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
use Drupal\DrupalExtension\Context\DrupalContext;

/**
 * Defines generic step definitions.
 */
class BaselineContext extends DrupalContext implements SnippetAcceptingContext {

    /**
     * @Then I do a little dance
     */
    public function iDoALittleDance()
    {
        var_dump($this->getSession()->getPage()->getHtml());
    }

}
