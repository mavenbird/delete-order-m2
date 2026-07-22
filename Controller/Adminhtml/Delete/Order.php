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

class Order extends AbstractSingleDelete
{
    /**
     * @var \Magento\Sales\Model\Order
     */
    protected $order;

    /**
     * @var \Mavenbird\DeleteOrder\Model\Order\Delete
     */
    protected $delete;

    /**
     * Order constructor.
     * @param Action\Context $context
     * @param \Magento\Sales\Model\Order $order
     * @param \Mavenbird\DeleteOrder\Model\Order\Delete $delete
     */
    public function __construct(
        Action\Context $context,
        \Magento\Sales\Model\Order $order,
        \Mavenbird\DeleteOrder\Model\Order\Delete $delete
    ) {
        $this->order = $order;
        $this->delete = $delete;
        $this->entityIdParam = 'order_id';
        $this->successMessageTemplate = 'Successfully deleted order #%1.';
        $this->errorMessageTemplate = 'Error delete order #%1.';
        $this->redirectPath = 'sales/order/';
        parent::__construct($context);
    }

    protected function getEntityIncrementId($entityId)
    {
        return (string)$this->order->load($entityId)->getIncrementId();
    }

    protected function deleteEntity($entityId)
    {
        $this->delete->deleteOrder($entityId);
    }
}
