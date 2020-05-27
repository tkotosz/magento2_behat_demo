<?php

namespace Inviqa\BehatDemo\Test;

use Magento\Framework\App\Config\ScopeConfigInterface;

class TestConfig implements ScopeConfigInterface
{
    /** @var array */
    private $mockConfig = [];

    public function getValue($path, $scopeType = ScopeConfigInterface::SCOPE_TYPE_DEFAULT, $scopeCode = null)
    {
        if (isset($this->mockConfig[$path])) {
            return $this->mockConfig[$path];
        }

        throw new \Exception('Unexpected Call!');
    }

    public function isSetFlag($path, $scopeType = ScopeConfigInterface::SCOPE_TYPE_DEFAULT, $scopeCode = null)
    {
        return (bool) $this->getValue($path, $scopeType, $scopeCode);
    }

    public function mockConfig(string $path, string $value): void
    {
        $this->mockConfig[$path] = $value;
    }

    public function clearMockConfig(): void
    {
        $this->mockConfig = [];
    }
}
