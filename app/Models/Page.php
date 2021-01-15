<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Page extends Model
{
    
    use HasFactory,Sluggable;
    protected $table = 'posts';
    public function sluggable(){
        return [
            'slug' => [
            'source' => 'title'
            ]
        ];
    }
    public function category(){
        return $this->belongsTo(Category::class , 'category_id' , 'id');
    }
    public function user(){
        return $this->belongsTo(User::class , 'user_id' , 'id');
    } 
    public function media(){
        return $this->hasMany(PostMedia::class,'post_id' , 'id');
    }
}
