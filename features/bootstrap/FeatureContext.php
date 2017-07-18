<?php

use Behat\Behat\Context\Context;
use Building\Domain\Aggregate\Building;
use PHPUnit\Framework\Assert;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{

    private $building;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->building = Building::new('Holiday Inn');
    }

    /**
     * @Given there is a building
     */
    public function thereIsABuilding()
    {
        Assert::assertInstanceOf(Building::class, $this->building);
    }

    /**
     * @Given guest named :arg1 is not checked in
     */
    public function guestNamedIsNotCheckedIn($arg1)
    {
        Assert::assertArrayNotHasKey($arg1, $this->reflectProperty('checkedInUsers'));
    }

    /**
     * @When guest with name :arg1 checks in
     */
    public function guestWithNameChecksIn($arg1)
    {
        $this->building->checkInUser($arg1);
        Assert::assertArrayHasKey($arg1, $this->reflectProperty('checkedInUsers'));
    }

    /**
     * @Then building must have one checked-in user named :arg1
     */
    public function buildingMustHaveOneCheckedInUserNamed($arg1)
    {
        Assert::assertCount(1, $this->reflectProperty('checkedInUsers'));
        Assert::assertArrayHasKey($arg1, $this->reflectProperty('checkedInUsers'));
    }

    /**
     * @Given guest named :arg1 is already checked in
     */
    public function guestNamedIsAlreadyCheckedIn($arg1)
    {
        $this->building->checkInUser($arg1);
        Assert::assertArrayHasKey($arg1, $this->reflectProperty('checkedInUsers'));
    }

    /**
     * @Then system must recognize multiple check in from :arg1
     */
    public function systemMustRecognizeMultipleCheckInFrom($arg1)
    {
        Assert::assertTrue($this->reflectProperty('multipleCheckInDetected'));
    }

    private function reflectProperty(string $property) {
        $buildingReflectionClass = new ReflectionClass(Building::class);
        $checkedInUsersReflectionProperty = $buildingReflectionClass->getProperty($property);
        $checkedInUsersReflectionProperty->setAccessible(true);
        return $checkedInUsersReflectionProperty->getValue($this->building);
    }
}
