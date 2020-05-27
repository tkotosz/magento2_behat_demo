<?php

namespace Inviqa\Acceptance\Context;

use Behat\Behat\Context\Context;
use Exception;
use Inviqa\BehatDemo\Generator\EmailGenerator;
use Inviqa\BehatDemo\Test\TestConfig;

class EmailGeneratorApplicationContext implements Context
{
    /** @var string */
    private $employeeName;

    /** @var string */
    private $generatedEmail;

    /** @var EmailGenerator */
    private $emailGenerator;

    /** @var TestConfig */
    private $testConfig;

    public function __construct(EmailGenerator $emailGenerator, TestConfig $testConfig)
    {
        $this->emailGenerator = $emailGenerator;
        $this->testConfig = $testConfig;
    }

    /**
     * @Given :name has joined the company
     */
    public function hasJoinedTheCompany(string $name)
    {
        $this->employeeName = $name;
    }

    /**
     * @Given the company email format is :format
     */
    public function theCompanyEmailFormatIs(string $format)
    {
        $this->testConfig->mockConfig(EmailGenerator::CONFIG_PATH_EMAIL_FORMAT, $format);
    }

    /**
     * @When the company email address is generated
     */
    public function theCompanyEmailAddressIsGenerated()
    {
        $this->generatedEmail = $this->emailGenerator->generate($this->employeeName);
    }

    /**
     * @Then it should equal :expected
     */
    public function itShouldEqual(string $expected)
    {
        if ($this->generatedEmail !== $expected) {
            throw new Exception('Email address doesn\'t match expected email address');
        }
    }
}
