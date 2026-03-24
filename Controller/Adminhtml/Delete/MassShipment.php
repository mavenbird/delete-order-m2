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

use Mavenbird\DeleteOrder\Model\Shipment\Delete;
use Magento\Backend\App\Action\Context;
use Magento\Sales\Model\Order\Shipment;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;
use Magento\Ui\Component\MassAction\Filter;

class MassShipment extends AbstractMassDelete
{
    /**
     * @var \Magento\Sales\Model\ResourceModel\Order\Shipment\CollectionFactory
     */
    protected $shipmentCollectionFactory;

    /**
     * @var \Magento\Sales\Model\Order\Shipment
     */
    protected $shipment;

    /**
     * @var \Mavenbird\DeleteOrder\Model\Shipment\Delete
     */
    protected $delete;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param \Magento\Sales\Model\ResourceModel\Order\Shipment\CollectionFactory $shipmentCollectionFactory
     * @param Shipment $shipment
     * @param Delete $delete
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        \Magento\Sales\Model\ResourceModel\Order\Shipment\CollectionFactory $shipmentCollectionFactory,
        \Magento\Sales\Model\Order\Shipment $shipment,
        \Mavenbird\DeleteOrder\Model\Shipment\Delete $delete
    ) {
        parent::__construct($context, $filter);
        $this->collectionFactory = $collectionFactory;
        $this->shipmentCollectionFactory = $shipmentCollectionFactory;
        $this->shipment = $shipment;
        $this->delete = $delete;
    }

    protected function getMassCollectionFactory()
    {
        return $this->shipmentCollectionFactory;
    }

    protected function getIncrementIdByEntity($entity, $entityId)
    {
        return (string)$this->getShipmentById($entityId)->getIncrementId();
    }

    protected function deleteEntity($entityId)
    {
        return $this->delete->deleteShipment($entityId);
    }

    protected function getSuccessMessageTemplate()
    {
        return 'Successfully deleted shipment #%1.';
    }

    protected function getErrorMessageTemplate()
    {
        return 'Error delete shipment #%1.';
    }

    protected function getDefaultRedirectPath()
    {
        return 'sales/shipment/';
    }

    protected function getOrderViewNamespace()
    {
        return 'sales_order_view_shipment_grid';
    }

    /**
     * @param int $shipmentId
     * @return \Magento\Sales\Model\Order\Shipment
     */
    protected function getShipmentById($shipmentId)
    {
        return $this->shipment->load($shipmentId);
    }
}
