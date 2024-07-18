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

namespace Mavenbird\DeleteOrder\Model;

use Magento\Framework\App\ProductMetadataInterface;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Magento\Sales\Model\ResourceModel\Order\Creditmemo\Collection as CreditmemoCollection;
use Magento\Sales\Model\ResourceModel\Order\Invoice\Collection;
use Magento\Sales\Model\ResourceModel\Order\Payment\Transaction\Collection as TransactionCollection;
use Magento\Sales\Model\ResourceModel\Order\Shipment\Collection as ShipmentCollection;

class Order extends AbstractModel
{
    /**
     * Metadata Interface
     *
     * @var [type]
     */
    protected $_appProductMetadataInterface;

    /**
     * Resource
     *
     * @var [type]
     */
    protected $_modelResource;

    /**
     * Manager Interface
     *
     * @var [type]
     */
    protected $_messageManagerInterface;

    /**
     * Invoice Collections
     *
     * @var [type]
     */
    protected $_invoiceCollection;

    /**
     * Shipment Collections
     *
     * @var [type]
     */
    protected $_shipmentCollection;
    
    /**
     * Credit Memo Collections
     *
     * @var [type]
     */
    protected $_creditmemoCollection;
    
    /**
     * Transaction Collections
     *
     * @var [type]
     */
    protected $_transactionCollection;

    /**
     * Construct
     *
     * @param Context $context
     * @param Registry $registry
     * @param ProductMetadataInterface $appProductMetadataInterface
     * @param \Magento\Framework\App\ResourceConnection $modelResource
     * @param ManagerInterface $messageManagerInterface
     * @param Collection $invoiceCollection
     * @param ShipmentCollection $shipmentCollection
     * @param CreditmemoCollection $creditmemoCollection
     * @param TransactionCollection $transactionCollection
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        ProductMetadataInterface $appProductMetadataInterface,
        \Magento\Framework\App\ResourceConnection $modelResource,
        ManagerInterface $messageManagerInterface,
        Collection $invoiceCollection,
        ShipmentCollection $shipmentCollection,
        CreditmemoCollection $creditmemoCollection,
        TransactionCollection $transactionCollection,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->_appProductMetadataInterface = $appProductMetadataInterface;
        $this->_modelResource = $modelResource;
        $this->_messageManagerInterface = $messageManagerInterface;
        $this->_invoiceCollection = $invoiceCollection;
        $this->_shipmentCollection = $shipmentCollection;
        $this->_creditmemoCollection = $creditmemoCollection;
        $this->_transactionCollection = $transactionCollection;

        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Delete Order
     *
     * @param array $orderIds
     * @return void
     */
    public function deleteOrder($orderIds = [])
    {
        $this->deteleRelated($orderIds);
        if ($this->_delete($orderIds)) {
            return true;
        }
        return false;
    }
    
    /**
     * Delete
     *
     * @param array $orderIds
     * @return void
     */
    public function _delete($orderIds = [])
    {

        $orderIds             = '(' . implode(",", $orderIds) . ')';
        $resource             = $this->_modelResource;
        $write                = $resource->getConnection('core_write');
        $saleFlatOrder  = $resource->getTableName('sales_order');
        $saleFlatOrderGrid = $resource->getTableName('sales_order_grid');

        try {
            $sql = "DELETE FROM " . $saleFlatOrder . " WHERE entity_id IN " . $orderIds . ";";
            $write->query($sql);
            $sql = "DELETE FROM  " . $saleFlatOrderGrid . " WHERE entity_id IN " . $orderIds . ";";
            $write->query($sql);
        } catch (\Exception $e) {
            $this->_messageManagerInterface->addError($e->getMessage());
        }

        return true;
    }
    
    /**
     * Delete Related
     *
     * @param array $orderIds
     * @return void
     */
    public function deteleRelated($orderIds = [])
    {
        try {
            // Remove Invoice Entry From Invoice Tabel
            $invoices = $this->_invoiceCollection->addFieldToFilter('order_id', ['in', $orderIds]);
            foreach ($invoices as $invoice) {
                $invoice->delete();
            }
            
            // Remove Invoice Entry From Invoice Grid
            $this->deleteGridData($orderIds, 'sales_invoice_grid');

            // Remove Shipment Entry From Shipment Tabel
            $shipments = $this->_shipmentCollection->addFieldToFilter('order_id', ['in', $orderIds]);
            foreach ($shipments as $shipment) {
                $shipment->delete();
            }

            // Remove Shipment Entry From Shipment Grid
            $this->deleteGridData($orderIds, 'sales_shipment_grid');
            
            // Remove Creditmemo Entry From Creditmemo Tabel
            $creditmemos = $this->_creditmemoCollection->addFieldToFilter('order_id', ['in', $orderIds]);
            foreach ($creditmemos as $creditmemo) {
                $creditmemo->delete();
            }

              // Remove Creditmemo Entry From Creditmemo Grid
            $this->deleteGridData($orderIds, 'sales_creditmemo_grid');

            $transactions = $this->_transactionCollection->addFieldToFilter('order_id', ['in', $orderIds]);
            foreach ($transactions as $transaction) {
                $transaction->delete();
            }
        } catch (\Exception $e) {
            $this->_messageManagerInterface->addError($e->getMessage());
        }
    }
    
    /**
     * Delete Grid Data
     *
     * @param [type] $orderId
     * @param [type] $Tabelname
     * @return void
     */
    public function deleteGridData($orderId, $Tabelname)
    {
        $orderId              = '(' . implode(",", $orderId) . ')';
        $resource             = $this->_modelResource;
        $write                = $resource->getConnection('core_write');
        $salesGrid                 = $resource->getTableName($Tabelname);

        try {
            $sql = "DELETE FROM  " . $salesGrid . " WHERE order_id IN " . $orderId . ";";
            $write->query($sql);
        } catch (\Exception $e) {
            $this->_messageManagerInterface->addError($e->getMessage());
        }
        
        return true;
    }
}
