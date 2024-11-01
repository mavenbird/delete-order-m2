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

namespace Mavenbird\DeleteOrder\Model\Shipment;

use Magento\Framework\App\ResourceConnection;

class Delete
{
    /**
     * @var ResourceConnection
     */
    protected $resource;

    /**
     * @var \Mavenbird\DeleteOrder\Helper\Data
     */
    protected $data;

    /**
     * @var \Magento\Sales\Model\Order\Shipment
     */
    protected $shipment;

    /**
     * @var \Magento\Sales\Model\Order
     */
    protected $order;

    /**
     * Delete constructor.
     * @param ResourceConnection $resource
     * @param \Mavenbird\DeleteOrder\Helper\Data $data
     * @param \Magento\Sales\Model\Order\Shipment $shipment
     * @param \Magento\Sales\Model\Order $order
     */
    public function __construct(
        ResourceConnection $resource,
        \Mavenbird\DeleteOrder\Helper\Data $data,
        \Magento\Sales\Model\Order\Shipment $shipment,
        \Magento\Sales\Model\Order $order
    ) {
        $this->resource = $resource;
        $this->data = $data;
        $this->shipment = $shipment;
        $this->order = $order;
    }

    /**
     * Delete Shipment
     *
     * @param [type] $shipmentId
     * @return void
     */
    public function deleteShipment($shipmentId)
    {
        $connection = $this->resource->getConnection(\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION);
        $shipmentTable = $connection->getTableName($this->data->getTableName('sales_shipment'));
        $shipmentGridTable = $connection->getTableName($this->data->getTableName('sales_shipment_grid'));
        $shipment = $this->shipment->load($shipmentId);
        $orderId = $shipment->getOrder()->getId();
        $order = $this->order->load($orderId);
        $orderItems = $order->getAllItems();
        $shipmentItems = $shipment->getAllItems();

        foreach ($orderItems as $item) {
            foreach ($shipmentItems as $shipmentItem) {
                if ($shipmentItem->getOrderItemId() == $item->getItemId()) {
                    $item->setQtyShipped($item->getQtyShipped() - $shipmentItem->getQty());
                }
            }
        }

        $connection->rawQuery('DELETE FROM `'.$shipmentGridTable.'` WHERE entity_id='.$shipmentId);
        $connection->rawQuery('DELETE FROM `'.$shipmentTable.'` WHERE entity_id='.$shipmentId);
        if ($order->hasShipments() || $order->hasInvoices() || $order->hasCreditmemos()) {
            $order->setState(\Magento\Sales\Model\Order::STATE_PROCESSING)
                ->setStatus($order->getConfig()->getStateDefaultStatus(\Magento\Sales\Model\Order::STATE_PROCESSING))
                ->save();
        } else {
            $order->setState(\Magento\Sales\Model\Order::STATE_NEW)
                ->setStatus($order->getConfig()->getStateDefaultStatus(\Magento\Sales\Model\Order::STATE_NEW))
                ->save();
        }

        return $order;
    }
}
