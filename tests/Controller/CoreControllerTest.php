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

namespace Sonata\AdminBundle\Tests\Controller;

use PHPUnit\Framework\TestCase;
use Sonata\AdminBundle\Action\DashboardAction;
use Sonata\AdminBundle\Admin\BreadcrumbsBuilderInterface;
use Sonata\AdminBundle\Admin\Pool;
use Sonata\AdminBundle\Controller\CoreController;
use Sonata\AdminBundle\Templating\MutableTemplateRegistryInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class CoreControllerTest extends TestCase
{
    /**
     * @group legacy
     */
    public function testdashboardActionStandardRequest(): void
    {
        $container = new Container();

        $templateRegistry = $this->createStub(MutableTemplateRegistryInterface::class);
        $templateRegistry->method('getTemplate')->willReturnMap([
            ['ajax', 'ajax.html'],
            ['dashboard', 'dashboard.html'],
            ['layout', 'layout.html'],
        ]);

        $pool = new Pool($container);
        $pool->setTemplateRegistry($templateRegistry);

        $twig = $this->createMock(Environment::class);
        $request = new Request();

        $requestStack = new RequestStack();
        $requestStack->push($request);

        $breadcrumbsBuilder = $this->getMockForAbstractClass(BreadcrumbsBuilderInterface::class);

        $container->set(DashboardAction::class, new DashboardAction(
            [],
            $breadcrumbsBuilder,
            $templateRegistry,
            $pool,
            $twig
        ));
        $container->set('request_stack', $requestStack);

        $controller = new CoreController();
        $controller->setContainer($container);

        static::assertInstanceOf(Response::class, $controller->dashboardAction());
    }

    /**
     * @group legacy
     */
    public function testdashboardActionAjaxLayout(): void
    {
        $container = new Container();

        $templateRegistry = $this->createStub(MutableTemplateRegistryInterface::class);
        $templateRegistry->method('getTemplate')->willReturnMap([
            ['ajax', 'ajax.html'],
            ['dashboard', 'dashboard.html'],
            ['layout', 'layout.html'],
        ]);
        $breadcrumbsBuilder = $this->createStub(BreadcrumbsBuilderInterface::class);

        $pool = new Pool($container);
        $pool->setTemplateRegistry($templateRegistry);

        $twig = $this->createMock(Environment::class);
        $request = new Request();
        $request->headers->set('X-Requested-With', 'XMLHttpRequest');

        $requestStack = new RequestStack();
        $requestStack->push($request);

        $container->set(DashboardAction::class, new DashboardAction(
            [],
            $breadcrumbsBuilder,
            $templateRegistry,
            $pool,
            $twig
        ));
        $container->set('request_stack', $requestStack);

        $controller = new CoreController();
        $controller->setContainer($container);

        $response = $controller->dashboardAction();

        static::assertInstanceOf(Response::class, $response);
    }
}
