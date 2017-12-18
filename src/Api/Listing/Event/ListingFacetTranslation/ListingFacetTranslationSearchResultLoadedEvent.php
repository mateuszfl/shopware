<?php declare(strict_types=1);

namespace Shopware\Api\Listing\Event\ListingFacetTranslation;

use Shopware\Api\Listing\Struct\ListingFacetTranslationSearchResult;
use Shopware\Context\Struct\TranslationContext;
use Shopware\Framework\Event\NestedEvent;

class ListingFacetTranslationSearchResultLoadedEvent extends NestedEvent
{
    const NAME = 'listing_facet_translation.search.result.loaded';

    /**
     * @var ListingFacetTranslationSearchResult
     */
    protected $result;

    public function __construct(ListingFacetTranslationSearchResult $result)
    {
        $this->result = $result;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getContext(): TranslationContext
    {
        return $this->result->getContext();
    }
}