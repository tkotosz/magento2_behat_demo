<?php

namespace Inviqa\Acceptance\Context;

use Behat\Behat\Context\Context;
use Inviqa\BehatDemo\Generator\EmailGenerator;
use Exception;
use Magento\Framework\App\Cache\Manager;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Config\Storage\Writer as ConfigWriter;

class EmailGeneratorEndToEndContext implements Context
{
    /** @var string */
    private $employeeName;

    /** @var string */
    private $generatedEmail;

    /** @var string|null */
    private $originalConfig;

    /** @var ScopeConfigInterface */
    private $config;

    /** @var ConfigWriter */
    private $configWriter;

    /** @var Manager */
    private $cacheManager;

    public function __construct(ScopeConfigInterface $config, ConfigWriter $configWriter, Manager $cacheManager)
    {
        $this->config = $config;
        $this->configWriter = $configWriter;
        $this->cacheManager = $cacheManager;
    }

    /**
     * @BeforeScenario
     */
    public function setUp()
    {
        $this->originalConfig = $this->config->getValue(EmailGenerator::CONFIG_PATH_EMAIL_FORMAT);
    }

    /**
     * @AfterScenario
     */
    public function tearDown()
    {
        $this->configWriter->save(EmailGenerator::CONFIG_PATH_EMAIL_FORMAT, $this->originalConfig);
        $this->originalConfig = null;
        $this->cacheManager->clean(['config']);
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
        $this->configWriter->save(EmailGenerator::CONFIG_PATH_EMAIL_FORMAT, $format);
        $this->cacheManager->clean(['config']);
    }

    /**
     * @When the company email address is generated
     */
    public function theCompanyEmailAddressIsGenerated()
    {
        $commandStatus = null;
        $this->generatedEmail = exec(sprintf('bin/magento generate:email:address %s', $this->employeeName), $commandStatus);
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
