<?php

namespace Rollbar\Symfony\RollbarBundle\Tests\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Rollbar\Symfony\RollbarBundle\DependencyInjection\RollbarExtension;

/**
 * Class RollbarExtensionTest
 *
 * @package Rollbar\Symfony\RollbarBundle\Tests\DependencyInjection
 */
class RollbarExtensionTest extends AbstractExtensionTestCase
{
    /**
     * Get container extensions.
     *
     * @link: https://github.com/matthiasnoback/SymfonyDependencyInjectionTest
     *
     * @return array
     */
    protected function getContainerExtensions(): array
    {
        return [
            new RollbarExtension(),
        ];
    }

    /**
     * Test config vars.
     *
     * @dataProvider generatorConfigVars
     */
    public function testConfigVars(string $var, array $expected, array $loadParameters = []): void
    {
        $this->load($loadParameters);

        $param = $this->container->getParameter($var);
        foreach ($expected as $key => $value) {
            $this->assertEquals($param[$key], $value);
        }
    }

    /**
     * Data provider generatorConfigVars.
     *
     * @return array
     */
    public function generatorConfigVars(): array
    {
        return [
            ['rollbar.config', ['enabled' => true]],
            ['rollbar.config', ['enabled' => false], ['enabled' => false]],
        ];
    }

    /**
     * Test alias.
     */
    public function testAlias(): void
    {
        $extension = new RollbarExtension();
        $this->assertEquals(RollbarExtension::ALIAS, $extension->getAlias());
    }
}
