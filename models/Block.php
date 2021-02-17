<?php namespace Rw\PageBuilder\Models;

use Model;

class Block extends Model
{
    use \October\Rain\Database\Traits\Validation;
    public $timestamps = false;
    public $table = 'rw_pagebuilder_blocks';
    public $rules = ['name' => 'required', 'type_id' => 'required'];
    protected $jsonable = ['fields'];
    public $translatable = [
        'fields[title]',
        'fields[content]',
    ];

    public $hasMany   = [
        'pages'  => [
            Page::class,
            'table' => 'rw_pagebuilder_block_page',
        ],
    ];

    public $belongsTo = [
        'blockType' => [
            BlockType::class,
            'table' => 'rw_pagebuilder_block_types',
            'key' => 'type_id',
        ],
    ];

    public $attachMany = [
        'images' => ['System\Models\File', 'delete' => true],
    ];

    public function getTypeIdOptions()
    {
        return BlockType::get()->pluck('name', 'id');
    }

    public function getTypeLabelAttribute()
    {
        return $this->type_id
            ? BlockType::find($this->type_id)->name
            : '-';
    }

    public function getExampleAttribute()
    {
        $blockType = BlockType::find($this->type_id);

        return isset($blockType->image)
            ? $blockType->image->getThumb(400, 300, 'auto')
            : false;
    }

    public function filterFields($fields, $context = null)
    {
        $visible = ['name', 'type_id', 'is_active', '_example', '_details'];
        foreach ($fields as $field) {
            $field->hidden = !in_array($field->fieldName, $visible) ? true : false;
        }

        $type = isset($fields->type_id->value) ? (int) $fields->type_id->value : null;
        $blockType = BlockType::find($type);

        if (
            isset($blockType)
            && isset($blockType->fields)
        ) {
            foreach ((array)$blockType->fields as $blockName) {
                @$fields->{$blockName}->hidden = false;
            }
            $fields->{'_example'}->value = @$this->getExampleAttribute();
        }
    }
}
