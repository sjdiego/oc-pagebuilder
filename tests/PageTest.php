<?php namespace Rw\PageBuilder\Tests;

use Rw\PageBuilder\Models\Page;
use PluginTestCase;

class PageTest extends PluginTestCase
{
    public function testCreateFirstPage()
    {
        Page::unguard();
        $page = Page::create([
            'name' => 'Test Page',
            'code' => 'testPage',
        ]);

        $this->assertEquals('test-page', $page->slug);
        $this->assertEquals(false, $page->is_active);
    }
}
