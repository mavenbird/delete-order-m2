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

namespace Mavenbird\DeleteOrder\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    /**
     * Configuration Interface
     *
     * @var [type]
     */
    protected $_configScopeConfigInterface;

    /**
     * Construct
     *
     * @param Context $context
     */
    public function __construct(Context $context)
    {
        parent::__construct($context);
    }

    /**
     * Enabled
     *
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->scopeConfig->getValue('deleteorder/general/enable', ScopeInterface::SCOPE_STORE);
    }
    
    /**
     * Order Button Label
     *
     * @return void
     */
    public function getOrderButtonLabel()
    {
        return $this->scopeConfig->getValue('deleteorder/general/btnheading', ScopeInterface::SCOPE_STORE);
    }
}
