<?php declare(strict_types=1);

namespace Shopware\Api\Config\Event\ConfigFormField;

use Shopware\Api\Config\Struct\ConfigFormFieldSearchResult;
use Shopware\Context\Struct\ShopContext;
use Shopware\Framework\Event\NestedEvent;

class ConfigFormFieldSearchResultLoadedEvent extends NestedEvent
{
    public const NAME = 'config_form_field.search.result.loaded';

    /**
     * @var ConfigFormFieldSearchResult
     */
    protected $result;

    public function __construct(ConfigFormFieldSearchResult $result)
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
