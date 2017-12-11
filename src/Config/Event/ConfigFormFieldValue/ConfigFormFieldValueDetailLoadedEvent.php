<?php declare(strict_types=1);

namespace Shopware\Config\Event\ConfigFormFieldValue;

use Shopware\Config\Collection\ConfigFormFieldValueDetailCollection;
use Shopware\Context\Struct\TranslationContext;
use Shopware\Framework\Event\NestedEvent;
use Shopware\Framework\Event\NestedEventCollection;
use Shopware\Shop\Event\Shop\ShopBasicLoadedEvent;

class ConfigFormFieldValueDetailLoadedEvent extends NestedEvent
{
    const NAME = 'config_form_field_value.detail.loaded';

    /**
     * @var TranslationContext
     */
    protected $context;

    /**
     * @var ConfigFormFieldValueDetailCollection
     */
    protected $configFormFieldValues;

    public function __construct(ConfigFormFieldValueDetailCollection $configFormFieldValues, TranslationContext $context)
    {
        $this->context = $context;
        $this->configFormFieldValues = $configFormFieldValues;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getContext(): TranslationContext
    {
        return $this->context;
    }

    public function getConfigFormFieldValues(): ConfigFormFieldValueDetailCollection
    {
        return $this->configFormFieldValues;
    }

    public function getEvents(): ?NestedEventCollection
    {
        $events = [];
        if ($this->configFormFieldValues->getShops()->count() > 0) {
            $events[] = new ShopBasicLoadedEvent($this->configFormFieldValues->getShops(), $this->context);
        }

        return new NestedEventCollection($events);
    }
}