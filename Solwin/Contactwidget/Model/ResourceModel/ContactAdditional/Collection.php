<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Solwin\Contactwidget\Model\ResourceModel\ContactAdditional;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    /**
     * @inheritDoc
     */
    protected $_idFieldName = 'contactadditional_id';

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(
            \Solwin\Contactwidget\Model\ContactAdditional::class,
            \Solwin\Contactwidget\Model\ResourceModel\ContactAdditional::class
        );
    }
}

