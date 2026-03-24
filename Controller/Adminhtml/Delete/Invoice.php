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

class Invoice extends AbstractSingleDelete
{
    /**
     * @var \Magento\Sales\Api\InvoiceRepositoryInterface
     */
    protected $invoiceRepository;

    /**
     * @var \Mavenbird\DeleteOrder\Model\Invoice\Delete
     */
    protected $delete;

    /**
     * Invoice constructor.
     * @param Action\Context $context
     * @param \Magento\Sales\Api\InvoiceRepositoryInterface $invoiceRepository
     * @param \Mavenbird\DeleteOrder\Model\Invoice\Delete $delete
     */
    public function __construct(
        Action\Context $context,
        \Magento\Sales\Api\InvoiceRepositoryInterface $invoiceRepository,
        \Mavenbird\DeleteOrder\Model\Invoice\Delete $delete
    ) {
        $this->invoiceRepository = $invoiceRepository;
        $this->delete = $delete;
        parent::__construct($context);
    }

    protected function getEntityIdParam()
    {
        return 'invoice_id';
    }

    protected function getEntityIncrementId($entityId)
    {
        return (string)$this->invoiceRepository->get($entityId)->getIncrementId();
    }

    protected function deleteEntity($entityId)
    {
        $this->delete->deleteInvoice($entityId);
    }

    protected function getSuccessMessageTemplate()
    {
        return 'Successfully deleted invoice #%1.';
    }

    protected function getErrorMessageTemplate()
    {
        return 'Error delete invoice #%1.';
    }

    protected function getRedirectPath()
    {
        return 'sales/invoice/';
    }
}
