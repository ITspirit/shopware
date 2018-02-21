<?php declare(strict_types=1);

namespace Shopware\Api\Config\Event\ConfigForm;

use Shopware\Api\Config\Struct\ConfigFormSearchResult;
use Shopware\Context\Struct\ShopContext;
use Shopware\Framework\Event\NestedEvent;

class ConfigFormSearchResultLoadedEvent extends NestedEvent
{
    public const NAME = 'config_form.search.result.loaded';

    /**
     * @var ConfigFormSearchResult
     */
    protected $result;

    public function __construct(ConfigFormSearchResult $result)
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
