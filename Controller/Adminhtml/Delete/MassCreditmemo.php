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

use Mavenbird\DeleteOrder\Model\Creditmemo\Delete;
use Magento\Backend\App\Action\Context;
use Magento\Sales\Api\CreditmemoRepositoryInterface;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;

class MassCreditmemo extends AbstractMassDelete
{
    /**
     * @var \Magento\Sales\Model\ResourceModel\Order\Creditmemo\CollectionFactory
     */
    protected $memoCollectionFactory;

    /**
     * @var \Magento\Sales\Api\CreditmemoRepositoryInterface
     */
    protected $creditmemoRepository;

    /**
     * @var \Mavenbird\DeleteOrder\Model\Creditmemo\Delete
     */
    protected $delete;

    /**
     * MassCreditmemo constructor.
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param \Magento\Sales\Model\ResourceModel\Order\Creditmemo\CollectionFactory $memoCollectionFactory
     * @param CreditmemoRepositoryInterface $creditmemoRepository
     * @param Delete $delete
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        \Magento\Sales\Model\ResourceModel\Order\Creditmemo\CollectionFactory $memoCollectionFactory,
        \Magento\Sales\Api\CreditmemoRepositoryInterface $creditmemoRepository,
        \Mavenbird\DeleteOrder\Model\Creditmemo\Delete $delete
    ) {
        parent::__construct($context, $filter);
        $this->collectionFactory = $collectionFactory;
        $this->memoCollectionFactory = $memoCollectionFactory;
        $this->creditmemoRepository = $creditmemoRepository;
        $this->delete = $delete;
    }

    protected function getMassCollectionFactory()
    {
        return $this->memoCollectionFactory;
    }

    protected function getIncrementIdByEntity($entity, $entityId)
    {
        return (string)$this->creditmemoRepository->get($entityId)->getIncrementId();
    }

    protected function deleteEntity($entityId)
    {
        return $this->delete->deleteCreditmemo($entityId);
    }

    protected function getSuccessMessageTemplate()
    {
        return 'Successfully deleted credit memo #%1.';
    }

    protected function getErrorMessageTemplate()
    {
        return 'Error delete credit memo #%1.';
    }

    protected function getDefaultRedirectPath()
    {
        return 'sales/creditmemo/';
    }

    protected function getOrderViewNamespace()
    {
        return 'sales_order_view_creditmemo_grid';
    }
}
