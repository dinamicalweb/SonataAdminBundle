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

namespace Sonata\AdminBundle\Tests\Form\Type;

use Sonata\AdminBundle\Form\Type\ModelHiddenType;
use Sonata\AdminBundle\Model\ModelManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModelHiddenTypeTest extends TypeTestCase
{
    public function testGetDefaultOptions(): void
    {
        $type = new ModelHiddenType();
        $modelManager = $this->getMockForAbstractClass(ModelManagerInterface::class);
        $optionResolver = new OptionsResolver();

        $type->configureOptions($optionResolver);

        $options = $optionResolver->resolve(['model_manager' => $modelManager, 'class' => '\Foo']);

        static::assertInstanceOf(ModelManagerInterface::class, $options['model_manager']);
        static::assertSame($modelManager, $options['model_manager']);
        static::assertSame('\Foo', $options['class']);
    }

    public function testGetBlockPrefix(): void
    {
        $type = new ModelHiddenType();
        static::assertSame('sonata_type_model_hidden', $type->getBlockPrefix());
    }

    public function testGetParent(): void
    {
        $type = new ModelHiddenType();
        static::assertSame(HiddenType::class, $type->getParent());
    }
}
