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

class Creditmemo extends AbstractSingleDelete
{
    /**
     * @var \Magento\Sales\Api\CreditmemoRepositoryInterface
     */
    protected $creditmemoRepository;
    /**
     * @var \Mavenbird\DeleteOrder\Model\Creditmemo\Delete
     */
    protected $delete;

    /**
     * Creditmemo constructor.
     * @param Action\Context $context
     * @param \Magento\Sales\Api\CreditmemoRepositoryInterface $creditmemoRepository
     * @param \Mavenbird\DeleteOrder\Model\Creditmemo\Delete $delete
     */
    public function __construct(
        Action\Context $context,
        \Magento\Sales\Api\CreditmemoRepositoryInterface $creditmemoRepository,
        \Mavenbird\DeleteOrder\Model\Creditmemo\Delete $delete
    ) {
        $this->creditmemoRepository = $creditmemoRepository;
        $this->delete = $delete;
        parent::__construct($context);
    }

    protected function getEntityIdParam()
    {
        return 'creditmemo_id';
    }

    protected function getEntityIncrementId($entityId)
    {
        return (string)$this->creditmemoRepository->get($entityId)->getIncrementId();
    }

    protected function deleteEntity($entityId)
    {
        $this->delete->deleteCreditmemo($entityId);
    }

    protected function getSuccessMessageTemplate()
    {
        return 'Successfully deleted credit memo #%1.';
    }

    protected function getErrorMessageTemplate()
    {
        return 'Error delete credit memo #%1.';
    }

    protected function getRedirectPath()
    {
        return 'sales/creditmemo/';
    }
}
