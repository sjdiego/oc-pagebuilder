<?php namespace Rw\PageBuilder;

use Event;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
        return [
            'RW\PageBuilder\Components\Page' => 'Page',
        ];
    }

    public function registerSettings()
    {
    }
}
