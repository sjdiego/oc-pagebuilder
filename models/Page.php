<?php namespace Rw\PageBuilder\Models;

use Model;

class Page extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\SoftDelete;
    use \October\Rain\Database\Traits\Sluggable;

    protected $slugs = ['slug' => 'name'];
    protected $dates = ['deleted_at'];
    public $table = 'rw_pagebuilder_pages';
    public $rules = [
        'name' => 'required',
        'code' => 'required|min:3|max:191|unique:rw_pagebuilder_pages',
        'slug' => 'unique:rw_pagebuilder_pages',
    ];
    public $translatable = [
        'name',
        ['slug', 'index' => true ],
    ];

    public $belongsToMany = [
        'blocks' => [
            Block::class,
            'table'    => 'rw_pagebuilder_block_page',
            'pivot'    => ['sort_order'],
            'key'      => 'page_id',
            'otherKey' => 'block_id',
        ],
    ];
    public $attachOne = [
        'featuredImage' => [
            'System\Models\File', ['delete' => true]
        ],
    ];

    public function scopeIsActive($q)
    {
        return $q->whereIsActive(true);
    }
}
