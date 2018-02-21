<?php
declare(strict_types=1);
/**
 * Shopware 5
 * Copyright (c) shopware AG
 *
 * According to our dual licensing model, this program can be used either
 * under the terms of the GNU Affero General Public License, version 3,
 * or under a proprietary license.
 *
 * The texts of the GNU Affero General Public License with an additional
 * permission and of our proprietary license can be found at and
 * in the LICENSE file you have received along with this program.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * "Shopware" is a registered trademark of shopware AG.
 * The licensing of the program under the AGPLv3 does not imply a
 * trademark license. Therefore any rights, title and interest in
 * our trademarks remain entirely with us.
 */

namespace Shopware\CartBridge\CustomerGroup;

use Shopware\Api\Customer\Collection\CustomerGroupDiscountBasicCollection;
use Shopware\Api\Customer\Repository\CustomerGroupDiscountRepository;
use Shopware\Api\Customer\Struct\CustomerGroupDiscountBasicStruct;
use Shopware\Api\Entity\Search\Criteria;
use Shopware\Api\Entity\Search\Query\TermQuery;
use Shopware\Cart\Cart\CollectorInterface;
use Shopware\Cart\Cart\Struct\Cart;
use Shopware\Context\Struct\StorefrontContext;
use Shopware\Framework\Struct\StructCollection;

class CustomerGroupDiscountCollector implements CollectorInterface
{
    /**
     * @var CustomerGroupDiscountRepository
     */
    private $customerGroupDiscountRepository;

    public function __construct(CustomerGroupDiscountRepository $customerGroupDiscountRepository)
    {
        $this->customerGroupDiscountRepository = $customerGroupDiscountRepository;
    }

    public function prepare(
        StructCollection $fetchDefinition,
        Cart $cart,
        StorefrontContext $context
    ): void {
    }

    public function fetch(
        StructCollection $dataCollection,
        StructCollection $fetchCollection,
        StorefrontContext $context
    ): void {
        $criteria = new Criteria();
        $criteria->addFilter(
            new TermQuery(
                'customer_group_discount.customerGroupId',
                $context->getCurrentCustomerGroup()->getId()
            )
        );
        $discounts = $this->customerGroupDiscountRepository->search($criteria, $context->getShopContext());

        $discounts->sort(function (CustomerGroupDiscountBasicStruct $a, CustomerGroupDiscountBasicStruct $b) {
            if ($a->getMinimumCartAmount() !== $b->getMinimumCartAmount()) {
                return -1;
            }

            return $a->getMinimumCartAmount() > $b->getMinimumCartAmount();
        });

        $dataCollection->add(new CustomerGroupDiscountBasicCollection($discounts->getElements()),
            CustomerGroupDiscountProcessor::class
        );
    }
}
