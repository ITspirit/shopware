<?php declare(strict_types=1);

namespace Shopware\Api\Customer\Definition;

use Shopware\Api\Customer\Collection\CustomerGroupBasicCollection;
use Shopware\Api\Customer\Collection\CustomerGroupDetailCollection;
use Shopware\Api\Customer\Event\CustomerGroup\CustomerGroupWrittenEvent;
use Shopware\Api\Customer\Repository\CustomerGroupRepository;
use Shopware\Api\Customer\Struct\CustomerGroupBasicStruct;
use Shopware\Api\Customer\Struct\CustomerGroupDetailStruct;
use Shopware\Api\Entity\EntityDefinition;
use Shopware\Api\Entity\EntityExtensionInterface;
use Shopware\Api\Entity\Field\BoolField;
use Shopware\Api\Entity\Field\DateField;
use Shopware\Api\Entity\Field\FloatField;
use Shopware\Api\Entity\Field\IdField;
use Shopware\Api\Entity\Field\OneToManyAssociationField;
use Shopware\Api\Entity\Field\StringField;
use Shopware\Api\Entity\Field\TranslatedField;
use Shopware\Api\Entity\Field\TranslationsAssociationField;
use Shopware\Api\Entity\FieldCollection;
use Shopware\Api\Entity\Write\Flag\PrimaryKey;
use Shopware\Api\Entity\Write\Flag\Required;

class CustomerGroupDefinition extends EntityDefinition
{
    /**
     * @var FieldCollection
     */
    protected static $primaryKeys;

    /**
     * @var FieldCollection
     */
    protected static $fields;

    /**
     * @var EntityExtensionInterface[]
     */
    protected static $extensions = [];

    public static function getEntityName(): string
    {
        return 'customer_group';
    }

    public static function getFields(): FieldCollection
    {
        if (self::$fields) {
            return self::$fields;
        }

        self::$fields = new FieldCollection([
            (new IdField('id', 'id'))->setFlags(new PrimaryKey(), new Required()),
            (new TranslatedField(new StringField('name', 'name')))->setFlags(new Required()),
            new BoolField('display_gross', 'displayGross'),
            new BoolField('input_gross', 'inputGross'),
            new BoolField('has_global_discount', 'hasGlobalDiscount'),
            new FloatField('percentage_global_discount', 'percentageGlobalDiscount'),
            new FloatField('minimum_order_amount', 'minimumOrderAmount'),
            new FloatField('minimum_order_amount_surcharge', 'minimumOrderAmountSurcharge'),
            new DateField('created_at', 'createdAt'),
            new DateField('updated_at', 'updatedAt'),
            new OneToManyAssociationField('customers', CustomerDefinition::class, 'customer_group_id', false, 'id'),
            new OneToManyAssociationField('discounts', CustomerGroupDiscountDefinition::class, 'customer_group_id', false, 'id'),
            (new TranslationsAssociationField('translations', CustomerGroupTranslationDefinition::class, 'customer_group_id', false, 'id'))->setFlags(new Required()),
        ]);

        foreach (self::$extensions as $extension) {
            $extension->extendFields(self::$fields);
        }

        return self::$fields;
    }

    public static function getRepositoryClass(): string
    {
        return CustomerGroupRepository::class;
    }

    public static function getBasicCollectionClass(): string
    {
        return CustomerGroupBasicCollection::class;
    }

    public static function getWrittenEventClass(): string
    {
        return CustomerGroupWrittenEvent::class;
    }

    public static function getBasicStructClass(): string
    {
        return CustomerGroupBasicStruct::class;
    }

    public static function getTranslationDefinitionClass(): ?string
    {
        return CustomerGroupTranslationDefinition::class;
    }

    public static function getDetailStructClass(): string
    {
        return CustomerGroupDetailStruct::class;
    }

    public static function getDetailCollectionClass(): string
    {
        return CustomerGroupDetailCollection::class;
    }
}