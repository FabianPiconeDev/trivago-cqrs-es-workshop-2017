<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @Given there is a building
     */
    public function thereIsABuilding()
    {
        throw new PendingException();
    }

    /**
     * @Given guest named :arg1 is not checked in
     */
    public function guestNamedIsNotCheckedIn($arg1)
    {
        throw new PendingException();
    }

    /**
     * @When guest with name :arg1 checks in
     */
    public function guestWithNameChecksIn($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then building must have one checked-in user named :arg1
     */
    public function buildingMustHaveOneCheckedInUserNamed($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Given guest named :arg1 is already checked in
     */
    public function guestNamedIsAlreadyCheckedIn($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then system must throw an exception that guest is already checked in
     */
    public function systemMustThrowAnExceptionThatGuestIsAlreadyCheckedIn()
    {
        throw new PendingException();
    }
}
