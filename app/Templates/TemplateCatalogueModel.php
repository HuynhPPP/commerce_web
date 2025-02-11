<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class {ModuleTemplate} extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'parent_id',
        'lft',
        'rgt',
        'level',
        'image',
        'icon',
        'album',
        'publish',
        'order',
        'user_id',
        'follow',  
    ];

    protected $table = '{tableName}';

    public function languages()
    {
        return $this->belongsToMany(Language::class, 
            '{pivotTable}', '{foreignKey}', 'language_id')
            ->withPivot(
                '{foreignKey}',
                'language_id',
                'name',
                'canonical',
                'meta_title',
                'meta_keyword',
                'meta_description',
                'description',
                'content'
            )->withTimestamps();
    }

    public function {relation}s(){
        return $this->belongToMany({relationModel}::class, 
        '{relationPivot}','{foreignKey}', '{relation}_id');
    }

    public function {module}_language(){
        return $this->hasMany({pivotModel}::class, '{foreignKey}', 'id');
    }

    public static function isNodeCheck($id = 0){
        ${relation}Catalogue = {ModuleTemplate}::find($id);

        if(${relation}Catalogue->rgt - ${relation}Catalogue->lft !== 1){
            return false;
        }

        return true;
    }
}
