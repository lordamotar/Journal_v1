<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*	подключение генератор ссылок*/ 
use Cviebrock\EloquentSluggable\Sluggable;

class post extends Model
{
	use Sluggable;
    /*функция  1 категория*/
	public	function 	category() 
	{
		return $this->hasOne(Category::class);
	}
	/* функция 1 автор*/
	public	function	author()	/* 1 автор*/
	{
		return $this->hasOne(User::class);
	}
	/* функция много тегов*/
	public	function	tags()
	{
		return $this->belongsToMany(
		Tag::Class,
			'Post_tags',
			'post_id',
			'tag_id'
		);
	}
	public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}