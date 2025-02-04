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

namespace Sonata\AdminBundle\Event;

use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Mapper\MapperInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * This event is sent by hook:
 *   - configureFormFields
 *   - configureListFields
 *   - configureDatagridFilters
 *   - configureShowFields.
 *
 * You can register the listener to the event dispatcher by using:
 *   - sonata.admin.event.configure.[form|list|datagrid|show]
 *   - sonata.admin.event.configure.[admin_code].[form|list|datagrid|show] (not implemented yet)
 *
 * @final since sonata-project/admin-bundle 3.52
 *
 * @author Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * @phpstan-template T of object
 */
class ConfigureEvent extends Event
{
    public const TYPE_SHOW = 'show';
    public const TYPE_DATAGRID = 'datagrid';
    public const TYPE_FORM = 'form';
    public const TYPE_LIST = 'list';

    /**
     * @var AdminInterface
     * @phpstan-var AdminInterface<T>
     */
    protected $admin;

    /**
     * @var MapperInterface
     * @phpstan-var MapperInterface<T>
     */
    protected $mapper;

    /**
     * @var string
     */
    protected $type;

    /**
     * @param string $type
     *
     * @phpstan-param AdminInterface<T> $admin
     * @phpstan-param MapperInterface<T> $mapper
     */
    public function __construct(AdminInterface $admin, MapperInterface $mapper, $type)
    {
        $this->admin = $admin;
        $this->mapper = $mapper;
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return AdminInterface
     * @phpstan-return AdminInterface<T>
     */
    public function getAdmin()
    {
        return $this->admin;
    }

    /**
     * @return MapperInterface
     * @phpstan-return MapperInterface<T>
     */
    public function getMapper()
    {
        return $this->mapper;
    }
}
