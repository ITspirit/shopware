<?php declare(strict_types=1);

namespace Shopware\Api\Config\Event\ConfigFormFieldTranslation;

use Shopware\Api\Config\Struct\ConfigFormFieldTranslationSearchResult;
use Shopware\Context\Struct\ShopContext;
use Shopware\Framework\Event\NestedEvent;

class ConfigFormFieldTranslationSearchResultLoadedEvent extends NestedEvent
{
    public const NAME = 'config_form_field_translation.search.result.loaded';

    /**
     * @var ConfigFormFieldTranslationSearchResult
     */
    protected $result;

    public function __construct(ConfigFormFieldTranslationSearchResult $result)
    {
        $this->result = $result;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getContext(): ShopContext
    {
        return $this->result->getContext();
    }
}
