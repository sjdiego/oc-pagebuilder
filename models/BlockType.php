<?php namespace Rw\PageBuilder\Models;

use App;
use Model;
use ApplicationException;
use PharIo\Manifest\Application;

class BlockType extends Model
{
    use \October\Rain\Database\Traits\Validation;
    public $timestamps = false;
    public $table = 'rw_pagebuilder_block_types';
    public $rules = ['name' => 'required'];
    protected $jsonable = ['fields'];
    protected $fillable = ['id', 'name', 'partial', 'fields', 'image'];

    public $hasMany = [
        'blocks' => [
            Block::class,
            'table' => 'rw_pagebuilder_blocks',
            'otherKey' => 'type_id',
        ],
    ];

    public $attachOne = [
        'image' => ['System\Models\File',  ['delete' => true]]
    ];

    public function getFieldsOptions()
    {
        return [
            'fields[title]' => 'Título',
            'fields[content]' => 'Contenido',
            'fields[video]' => 'Video',
            'fields[url]' => 'URL',
            'images' => 'Imágenes',
        ];
    }

    public function getPartialOptions()
    {
        // Get folder where partials are stored
        $files = @scandir(themes_path() . '/pagebuilder/partials/page/blocks');
        if (!$files) {
            return [];
        }

        $partials = array_diff($files, ['.', '..']);
        $values[] = '-- Seleccione un partial --';

        foreach ($partials as $partial) {
            $name = str_replace('.htm', '', $partial);
            $name = str_replace('-', ' ', $name);
            $values['page/blocks/'.$partial] = ucwords($name);
        }

        return $values;
    }
}
