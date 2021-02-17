<?php namespace Rw\PageBuilder\Tests;

use Rw\PageBuilder\Models\BlockType;
use Rw\PageBuilder\Models\Block;
use PluginTestCase;

class BlockTest extends PluginTestCase
{
    public function testCreateFirstBlockType()
    {
        BlockType::unguard();
        $blockType = BlockType::create([
            'name' => 'Test BlockType',
        ]);

        $this->assertInstanceOf(BlockType::class, $blockType);
    }

    public function testCreateFirstBlock()
    {
        BlockType::unguard();
        $blockType = BlockType::create([
            'name' => 'Test BlockType',
        ]);

        Block::unguard();
        $block = Block::create([
            'name' => 'Test Block',
            'fields' => json_encode(['title' => 'BlockType created to generate a test block']),
            'type_id' => $blockType->id,
        ]);

        $this->assertInstanceOf(Block::class, $block);
    }
}
