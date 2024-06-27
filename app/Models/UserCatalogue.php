<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class UserCatalogue extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'publish'
        
        
    ];

    protected $table = 'user_catalogues_tables';

    public function users(){
        return $this->hasMany(User::class, 'user_catalogue_id', 'id');
    }
}
