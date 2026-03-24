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

namespace Mavenbird\DeleteOrder\Plugin\Invoice;

class PluginAfter extends \Mavenbird\DeleteOrder\Plugin\AbstractDeleteButtonPlugin
{
    protected function getViewActionName()
    {
        return 'sales_order_invoice_view';
    }

    protected function getDeleteRoute()
    {
        return 'deleteorder/delete/invoice';
    }

    protected function getEntityParamName()
    {
        return 'invoice_id';
    }
}
