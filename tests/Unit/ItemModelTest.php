<?php

namespace Tests\Unit;

use App\Blizzard\Warcraft\Item;
use Tests\TestCase;

class ItemModelTest extends TestCase
{
    public function testLinksAttribute()
    {
        $item = new Item([
          '_links' => ['self' => ['href' => 'https://eu.api.blizzard.com/data/wow/item/24358?namespace=static-1.13.4_33598-classic-eu']]
        ]);

        $this->assertInstanceOf(Item::class, $item);
        $this->assertNotNull($item->getAttribute('_links'));
        $this->assertIsObject($item->_links);
        $this->assertObjectHasAttribute('self', $item->_links);
        $this->assertIsObject($item->_links->self);
        $this->assertObjectHasAttribute('href', $item->_links->self);
        $this->assertEquals('https://eu.api.blizzard.com/data/wow/item/24358?namespace=static-1.13.4_33598-classic-eu', $item->_links->self->href);
    }

    public function testIdAttribute()
    {
        $item = new Item(['id' => 24358]);

        $this->assertInstanceOf(Item::class, $item);
        $this->assertNotNull($item->getAttribute('id'));
        $this->assertIsInt($item->id);
        $this->assertEquals(24358, $item->id);
    }

    public function testIdAttributeCasting()
    {
        $item = new Item(['id' => '24358']);

        $this->assertInstanceOf(Item::class, $item);
        $this->assertNotNull($item->getAttribute('id'));
        $this->assertIsInt($item->id);
        $this->assertEquals(24358, $item->id);
    }

    public function testNameAttribute()
    {
        $item = new Item(['name' => 'QATest +1000 Spell Dmg Ring']);

        $this->assertInstanceOf(Item::class, $item);
        $this->assertNotNull($item->getAttribute('name'));
        $this->assertEquals('QATest +1000 Spell Dmg Ring', $item->name);
    }

    public function testQualityAttribute()
    {
        $item = new Item([
            'quality' => ['type' => 'EPIC', 'name' => 'Epic']
        ]);

        $this->assertInstanceOf(Item::class, $item);
        $this->assertNotNull($item->getAttribute('quality'));
        $this->assertIsObject($item->quality);
        $this->assertObjectHasAttribute('type', $item->quality);
        $this->assertEquals('EPIC', $item->quality->type);
        $this->assertObjectHasAttribute('name', $item->quality);
        $this->assertEquals('Epic', $item->quality->name);
    }

    public function testLevelAttribute()
    {
        $item = new Item(['level' => 6]);

        $this->assertInstanceOf(Item::class, $item);
        $this->assertNotNull($item->getAttribute('level'));
        $this->assertIsInt($item->level);
        $this->assertEquals(6, $item->level);
    }

    public function testLevelAttributeCasting()
    {
        $item = new Item(['level' => '6']);

        $this->assertInstanceOf(Item::class, $item);
        $this->assertNotNull($item->getAttribute('level'));
        $this->assertIsInt($item->level);
        $this->assertEquals(6, $item->level);
    }

    public function testRequiredLevelAttribute()
    {
        $item = new Item(['required_level' => 1]);

        $this->assertInstanceOf(Item::class, $item);
        $this->assertNotNull($item->getAttribute('required_level'));
        $this->assertIsInt($item->required_level);
        $this->assertEquals(1, $item->required_level);
    }

    public function testRequiredLevelAttributeCasting()
    {
        $item = new Item(['required_level' => '1']);

        $this->assertInstanceOf(Item::class, $item);
        $this->assertNotNull($item->getAttribute('required_level'));
        $this->assertIsInt($item->required_level);
        $this->assertEquals(1, $item->required_level);
    }

    public function testMediaAttribute()
    {
        $item = new Item([
            'media' => [
                'key' => ['href' => 'https://eu.api.blizzard.com/data/wow/media/item/24358?namespace=static-1.13.4_33598-classic-eu'],
                'id' => 24358
            ]
        ]);

        $this->assertInstanceOf(Item::class, $item);
        $this->assertNotNull($item->getAttribute('media'));
        $this->assertIsObject($item->media);
        $this->assertObjectHasAttribute('key', $item->media);
        $this->assertIsObject($item->media->key);
        $this->assertObjectHasAttribute('href', $item->media->key);
        $this->assertEquals('https://eu.api.blizzard.com/data/wow/media/item/24358?namespace=static-1.13.4_33598-classic-eu', $item->media->key->href);
        $this->assertObjectHasAttribute('id', $item->media);
        $this->assertIsInt($item->media->id);
        $this->assertEquals(24358, $item->media->id);
        $this->assertObjectNotHasAttribute('assets', $item->media);
    }

    public function testItemClassAttribute()
    {
        $item = new Item([
            'item_class' => [
                'key' => ['href' => 'https://eu.api.blizzard.com/data/wow/item-class/4?namespace=static-1.13.4_33598-classic-eu'],
                'name' => 'Armor',
                'id' => 4,
            ]
        ]);

        $this->assertInstanceOf(Item::class, $item);
        $this->assertNotNull($item->getAttribute('item_class'));
        $this->assertIsObject($item->item_class);
        $this->assertObjectHasAttribute('key', $item->item_class);
        $this->assertIsObject($item->item_class->key);
        $this->assertObjectHasAttribute('href', $item->item_class->key);
        $this->assertEquals('https://eu.api.blizzard.com/data/wow/item-class/4?namespace=static-1.13.4_33598-classic-eu', $item->item_class->key->href);
        $this->assertObjectHasAttribute('name', $item->item_class);
        $this->assertEquals('Armor', $item->item_class->name);
        $this->assertObjectHasAttribute('id', $item->item_class);
        $this->assertIsInt($item->item_class->id);
        $this->assertEquals(4, $item->item_class->id);
    }

    public function testItemSubclassAttribute()
    {
        $item = new Item([
            'item_class' => [
                'key' => ['href' => 'https://eu.api.blizzard.com/data/wow/item-class/4/item-subclass/0?namespace=static-1.13.4_33598-classic-eu'],
                'name' => 'Miscellaneous',
                'id' => 0,
            ]
        ]);

        $this->assertInstanceOf(Item::class, $item);
        $this->assertNotNull($item->getAttribute('item_class'));
        $this->assertIsObject($item->item_class);
        $this->assertObjectHasAttribute('key', $item->item_class);
        $this->assertIsObject($item->item_class->key);
        $this->assertObjectHasAttribute('href', $item->item_class->key);
        $this->assertEquals('https://eu.api.blizzard.com/data/wow/item-class/4/item-subclass/0?namespace=static-1.13.4_33598-classic-eu', $item->item_class->key->href);
        $this->assertObjectHasAttribute('name', $item->item_class);
        $this->assertEquals('Miscellaneous', $item->item_class->name);
        $this->assertObjectHasAttribute('id', $item->item_class);
        $this->assertIsInt($item->item_class->id);
        $this->assertEquals(0, $item->item_class->id);
    }

    public function testInventoryTypeAttribute()
    {
        $item = new Item([
            'inventory_type' => [
                'type' => 'FINGER',
                'name' => 'Finger',
            ]
        ]);

        $this->assertInstanceOf(Item::class, $item);
        $this->assertNotNull($item->getAttribute('inventory_type'));
        $this->assertIsObject($item->inventory_type);
        $this->assertObjectHasAttribute('type', $item->inventory_type);
        $this->assertEquals('FINGER', $item->inventory_type->type);
        $this->assertObjectHasAttribute('name', $item->inventory_type);
        $this->assertEquals('Finger', $item->inventory_type->name);
    }

    public function testPurchasePriceAttribute()
    {
        $item = new Item(['purchase_price' => 365815]);

        $this->assertInstanceOf(Item::class, $item);
        $this->assertNotNull($item->getAttribute('purchase_price'));
        $this->assertIsInt($item->purchase_price);
        $this->assertEquals(365815, $item->purchase_price);
    }

    public function testPurchasePriceAttributeCasting()
    {
        $item = new Item(['purchase_price' => '365815']);

        $this->assertInstanceOf(Item::class, $item);
        $this->assertNotNull($item->getAttribute('purchase_price'));
        $this->assertIsInt($item->purchase_price);
        $this->assertEquals(365815, $item->purchase_price);
    }

    public function testSellPriceAttribute()
    {
        $item = new Item(['sell_price' => 91453]);

        $this->assertInstanceOf(Item::class, $item);
        $this->assertNotNull($item->getAttribute('sell_price'));
        $this->assertIsInt($item->sell_price);
        $this->assertEquals(91453, $item->sell_price);
    }

    public function testSellPriceAttributeCasting()
    {
        $item = new Item(['sell_price' => '91453']);

        $this->assertInstanceOf(Item::class, $item);
        $this->assertNotNull($item->getAttribute('sell_price'));
        $this->assertIsInt($item->sell_price);
        $this->assertEquals(91453, $item->sell_price);
    }

    public function testMaxCountAttribute()
    {
        $item = new Item(['max_count' => 0]);

        $this->assertInstanceOf(Item::class, $item);
        $this->assertNotNull($item->getAttribute('max_count'));
        $this->assertIsInt($item->max_count);
        $this->assertEquals(0, $item->max_count);
    }

    public function testMaxCountAttributeCasting()
    {
        $item = new Item(['max_count' => '0']);

        $this->assertInstanceOf(Item::class, $item);
        $this->assertNotNull($item->getAttribute('max_count'));
        $this->assertIsInt($item->max_count);
        $this->assertEquals(0, $item->max_count);
    }

    public function testIsEquippableAttribute()
    {
        $item = new Item(['is_equippable' => true]);

        $this->assertInstanceOf(Item::class, $item);
        $this->assertNotNull($item->getAttribute('is_equippable'));
        $this->assertIsBool($item->is_equippable);
        $this->assertTrue($item->is_equippable);
    }

    public function testIsStackableAttribute()
    {
        $item = new Item(['is_stackable' => false]);

        $this->assertInstanceOf(Item::class, $item);
        $this->assertNotNull($item->getAttribute('is_stackable'));
        $this->assertIsBool($item->is_stackable);
        $this->assertFalse($item->is_stackable);
    }
}
