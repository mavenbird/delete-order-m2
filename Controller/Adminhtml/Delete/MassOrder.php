<?php
/**
 * Mavenbird Technologies Private Limited
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://mavenbird.com/Mavenbird-Module-License.txt
 *
 * =================================================================
 *
 * @category   Mavenbird
 * @package    Mavenbird_DeleteOrder
 * @author     Mavenbird Team
 * @copyright  Copyright (c) 2018-2024 Mavenbird Technologies Private Limited ( http://mavenbird.com )
 * @license    http://mavenbird.com/Mavenbird-Module-License.txt
 */

namespace Mavenbird\DeleteOrder\Controller\Adminhtml\Delete;

use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;
use Magento\Sales\Api\OrderManagementInterface;

class MassOrder extends AbstractMassDelete
{
    /**
     * @var OrderManagementInterface
     */
    protected $orderManagement;

    /**
     * @var CollectionFactory
     */
    protected $orderCollectionFactory;

    /**
     * @var \Mavenbird\DeleteOrder\Model\Order\Delete
     */
    protected $delete;

    /**
     * Construct
     *
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param OrderManagementInterface $orderManagement
     * @param \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory
     * @param \Mavenbird\DeleteOrder\Model\Order\Delete $delete
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        OrderManagementInterface $orderManagement,
        \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory,
        \Mavenbird\DeleteOrder\Model\Order\Delete $delete
    ) {
        parent::__construct($context, $filter);
        $this->collectionFactory = $collectionFactory;
        $this->orderManagement = $orderManagement;
        $this->orderCollectionFactory = $orderCollectionFactory;
        $this->delete = $delete;
    }

    protected function getMassCollectionFactory()
    {
        return $this->orderCollectionFactory;
    }

    protected function getIncrementIdByEntity($entity, $entityId)
    {
        return (string)$entity->getIncrementId();
    }

    protected function deleteEntity($entityId)
    {
        return $this->delete->deleteOrder($entityId);
    }

    protected function getSuccessMessageTemplate()
    {
        return 'Successfully deleted order #%1.';
    }

    protected function getErrorMessageTemplate()
    {
        return 'Error delete order #%1.';
    }

    protected function getDefaultRedirectPath()
    {
        return 'sales/order/';
    }
}
