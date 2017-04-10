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

namespace Shopware\Bundle\CartBundle\Infrastructure\View;

use Shopware\Bundle\CartBundle\Domain\Cart\CalculatedCart;
use Shopware\Bundle\StoreFrontBundle\Struct\ShopContextInterface;

class ViewCartTransformer
{
    /**
     * @var ViewLineItemTransformerInterface[]
     */
    private $transformers;

    public function __construct(array $transformers)
    {
        $this->transformers = $transformers;
    }

    public function transform(CalculatedCart $calculatedCart, ShopContextInterface $context): ViewCart
    {
        $viewCart = ViewCart::createFromCalculatedCart($calculatedCart);

        foreach ($this->transformers as $transformer) {
            $transformer->transform($calculatedCart, $viewCart, $context);
        }

        $viewCart->getViewLineItems()->sortByIdentifiers(
            $calculatedCart->getCalculatedLineItems()->getIdentifiers()
        );

        return $viewCart;
    }
}