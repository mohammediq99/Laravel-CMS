<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Nicolaslopezj\Searchable\SearchableTrait;

class Post extends Model
{
    use HasFactory,Sluggable,SearchableTrait;
    protected $guarded = [];
    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'posts.title' => 10,
            'posts.description' => 9
        ] 
    ];
    public function sluggable(){
        return [
            'slug' => [
            'source' => 'title'
            ]
        ];
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    
    public function comments(){
        return $this->hasMany(Comment::class);
    }
    public function approved_comments(){
        return $this->hasMany(Comment::class)->whereStatus(1);
    }
    
    public function media(){
        return $this->hasMany(PostMedia::class);
    }
    
    
}
