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
use Symfony\Component\EventDispatcher\Event;

/**
 * This event is sent by hook:
 *   - preUpdate | postUpdate
 *   - prePersist | postPersist
 *   - preRemove | postRemove.
 *
 * You can register the listener to the event dispatcher by using:
 *   - sonata.admin.event.persistence.[pre|post]_[persist|update|remove)
 *   - sonata.admin.event.persistence.[admin_code].[pre|post]_[persist|update|remove)  (not implemented yet)
 *
 * @final since sonata-project/admin-bundle 3.52
 *
 * @author Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * @phpstan-template T of object
 */
class PersistenceEvent extends Event
{
    public const TYPE_PRE_UPDATE = 'pre_update';
    public const TYPE_POST_UPDATE = 'post_update';
    public const TYPE_PRE_PERSIST = 'pre_persist';
    public const TYPE_POST_PERSIST = 'post_persist';
    public const TYPE_PRE_REMOVE = 'pre_remove';
    public const TYPE_POST_REMOVE = 'post_remove';

    /**
     * @var AdminInterface
     * @phpstan-var AdminInterface<T>
     */
    protected $admin;

    /**
     * @var object
     * @phpstan-var T
     */
    protected $object;

    /**
     * @var string
     */
    protected $type;

    /**
     * @param object $object
     * @param string $type
     *
     * @phpstan-param AdminInterface<T> $admin
     * @phpstan-param T $object
     */
    public function __construct(AdminInterface $admin, $object, $type)
    {
        $this->admin = $admin;
        $this->object = $object;
        $this->type = $type;
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
     * @return object
     * @phpstan-return T
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}
