<?php

declare(strict_types=1);

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\AdminBundle\Tests\Form\Extension;

use PHPUnit\Framework\TestCase;
use Sonata\AdminBundle\Form\Extension\ChoiceTypeExtension;
use Sonata\AdminBundle\Tests\Fixtures\TestExtension;
use Sonata\CoreBundle\Form\Extension\DependencyInjectionExtension;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\Forms;

class ChoiceTypeExtensionTest extends TestCase
{
    /**
     * @var FormFactoryInterface
     */
    private $factory;

    protected function setUp(): void
    {
        if (class_exists(DependencyInjectionExtension::class)) {
            $container = new Container();
            $container->set('sonata.admin.form.choice_extension', new ChoiceTypeExtension());

            $typeServiceIds = [];
            $typeExtensionServiceIds = [];
            $guesserServiceIds = [];
            $mappingTypes = [
                'choice' => ChoiceType::class,
            ];
            $extensionTypes = [
                'choice' => [
                    'sonata.admin.form.choice_extension',
                ],
            ];

            $extension = new DependencyInjectionExtension(
                $container,
                $typeServiceIds,
                $typeExtensionServiceIds,
                $guesserServiceIds,
                $mappingTypes,
                $extensionTypes
            );
        } else {
            $extension = new TestExtension(null);
            $extension->addTypeExtension(new ChoiceTypeExtension());
        }

        $this->factory = Forms::createFormFactoryBuilder()
            ->addExtension($extension)
            ->getFormFactory();
    }

    public function testExtendedType(): void
    {
        $extension = new ChoiceTypeExtension();

        static::assertSame(
            ChoiceType::class,
            $extension->getExtendedType()
        );

        static::assertSame(
            [ChoiceType::class],
            ChoiceTypeExtension::getExtendedTypes()
        );
    }

    public function testDefaultOptionsWithSortable(): void
    {
        $view = $this->factory
            ->create(ChoiceType::class, null, [
                'sortable' => true,
            ])
            ->createView();

        static::assertTrue(isset($view->vars['sortable']));
        static::assertTrue($view->vars['sortable']);
    }

    public function testDefaultOptionsWithoutSortable(): void
    {
        $view = $this->factory
            ->create(ChoiceType::class, null, [])
            ->createView();

        static::assertTrue(isset($view->vars['sortable']));
        static::assertFalse($view->vars['sortable']);
    }
}
