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

use Magento\Backend\App\Action;

class Shipment extends AbstractSingleDelete
{
    /**
     * @var \Magento\Sales\Model\Order\Shipment
     */
    protected $shipment;

    /**
     * @var \Mavenbird\DeleteOrder\Model\Shipment\Delete
     */
    protected $delete;

    /**
     * Shipment constructor.
     * @param Action\Context $context
     * @param \Magento\Sales\Model\Order\Shipment $shipment
     * @param \Mavenbird\DeleteOrder\Model\Shipment\Delete $delete
     */
    public function __construct(
        Action\Context $context,
        \Magento\Sales\Model\Order\Shipment $shipment,
        \Mavenbird\DeleteOrder\Model\Shipment\Delete $delete
    ) {
        $this->shipment = $shipment;
        $this->delete = $delete;
        parent::__construct($context);
    }

    protected function getEntityIdParam()
    {
        return 'shipment_id';
    }

    protected function getEntityIncrementId($entityId)
    {
        return (string)$this->shipment->load($entityId)->getIncrementId();
    }

    protected function deleteEntity($entityId)
    {
        $this->delete->deleteShipment($entityId);
    }

    protected function getSuccessMessageTemplate()
    {
        return 'Successfully deleted shipment #%1.';
    }

    protected function getErrorMessageTemplate()
    {
        return 'Error delete shipment #%1.';
    }

    protected function getRedirectPath()
    {
        return 'sales/shipment/';
    }
}
