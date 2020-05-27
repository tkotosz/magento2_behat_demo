<?php

namespace Inviqa\BehatDemo\Generator;

use Magento\Framework\App\Config\ScopeConfigInterface;

class EmailGenerator
{
    public const CONFIG_PATH_EMAIL_FORMAT = 'inviqa/behat_demo/email_format';

    /** @var ScopeConfigInterface */
    private $scopeConfig;

    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    public function generate(string $employeeName): string
    {
        return str_replace('username', strtolower($employeeName), $this->scopeConfig->getValue(self::CONFIG_PATH_EMAIL_FORMAT));
    }
}
