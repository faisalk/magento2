<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Magento
 * @package     Magento_Reports
 * @copyright   Copyright (c) 2013 X.commerce, Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Adminhtml wishlist report page content block
 *
 * @category   Magento
 * @package    Magento_Reports
 * @author      Magento Core Team <core@magentocommerce.com>
 */
namespace Magento\Reports\Block\Adminhtml;

class Wishlist extends \Magento\Backend\Block\Template
{

    public $wishlists_count;
    public $items_bought;
    public $shared_count;
    public $referrals_count;
    public $conversions_count;
    public $customer_with_wishlist;

    protected $_template = 'report/wishlist.phtml';

    /**
     * Reports wishlist collection factory
     *
     * @var \Magento\Reports\Model\Resource\Wishlist\CollectionFactory
     */
    protected $_wishlistFactory;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Reports\Model\Resource\Wishlist\CollectionFactory $wishlistFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Reports\Model\Resource\Wishlist\CollectionFactory $wishlistFactory,
        array $data = array()
    ) {
        $this->_wishlistFactory = $wishlistFactory;
        parent::__construct($context, $data);
    }

    public function _beforeToHtml()
    {
        $this->setChild(
            'grid',
            $this->getLayout()->createBlock('Magento\Reports\Block\Adminhtml\Wishlist\Grid', 'report.grid')
        );

        $collection = $this->_wishlistFactory->create();

        list($customerWithWishlist, $wishlistsCount) = $collection->getWishlistCustomerCount();
        $this->setCustomerWithWishlist($customerWithWishlist);
        $this->setWishlistsCount($wishlistsCount);
        $this->setItemsBought(0);
        $this->setSharedCount($collection->getSharedCount());
        $this->setReferralsCount(0);
        $this->setConversionsCount(0);

        return $this;
    }

}
