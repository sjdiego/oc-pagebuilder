<?php namespace Rw\PageBuilder\Components;

use Cms\Classes\ComponentBase;
use \Cms\Classes\Page as CmsPage;
use \RW\PageBuilder\Models\Page as PageModel;
use Redirect;

class Page extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'Page Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [
            'slug' => [
                'title' => 'Slug',
                'type' => 'string',
            ],
        ];
    }

    public function onRun()
    {
        try {
            if (!$this->property('slug')) {
                throw new Exception("You must set a slug to find a page");
            }

            $page = PageModel::isActive()
                ->transWhere('slug', $this->property('slug'))
                ->with(['blocks' => function ($q) {
                    return $q->with('blockType')->orderBy('pivot_sort_order');
                }])->firstOrFail();

            $this->page->title = $page->name;
            $this->page['page'] = $page;
        } catch (\Exception $e) {
            $errorData = [
                'page'   => $this->page->id,
                'slug'   => $this->property('slug'),
                'error'  => $e->getMessage(),
                'origin' => $_SERVER['REMOTE_ADDR'],
                'agent'  => $_SERVER['HTTP_USER_AGENT'],
            ];
            trace_log($errorData);
            $this->setStatusCode(404);
            return $this->controller->run('404');
        }
    }
}
