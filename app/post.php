<?php

namespace App;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

/*	подключение генератор ссылок*/ 
use Cviebrock\EloquentSluggable\Sluggable;

class post extends Model
{
	use Sluggable;
	
	const IS_DRAFT = 0;
	const IS_PUBLIC = 1;

	/* присвоение значении */
	protected	$fillable = ['title','content'];
	
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
	/* добавление новой записи */ 
	public	static	function add($fields)
	{
		$post	=	new	static;
		$post->fill([$fields]);
		$post->save();
		$post->user_id =1;
		return	$post;
	}
	/* измененние записи */ 
	public	function	edit($fields)
	{
		$this->fill($fields);
		$this->save();
	}
	/* удаление записи */ 
	public	function	remove()
	{
		Storage::delete('uploads/' . $this->image);
		$this->delete();
	}
	/* загрузка картинки */ 
	public	function	uploadImage($image)
	{
		if(image == null){return;}
		Storage::delete('uploads/' . $this->image);
		$filename = str_random(10) .'.'. $image->extension();
		$image->saveAs('uploads', $filename);
		$this->image=$filename;
		$this->save();
	}
	/* вывод изображении */ 	
	public	function getImage($value='')
	{
		if($this->image	==	null)
		{
			return	'/img/no-image.png';
		}
		return	'/upploads/' . $this->image;
		
	}
	
	/* привязка категории */ 
	public	function	setCategory($id)
	{
		if($id == null) {return;}
		
		$this->category_id	=	$id;
		$this->save();
	}
	/* привязка тегов */ 
	public	function	setTags($id)
	{
		if($ids == null){return;}
		
		$this->tags()->sync($ids);
	}
	/* добавление статуса*/
	public	function	setDraft()
	{
		$this->status	=	Post::IS_DRAFT; // чтобы заработал надо добавить сверху константу
		$this->save();
	}
	public	function	setPublic()
	{
		$this->status	=	Post::IS_PUBLIC;// чтобы заработал надо добавить сверху константу
		$this->save();
	}
	public	function	toggleStatus($value)
	{
		if($value	==	null)
		{
			return$this->setDraft();
		}
		else
		{
			return$this->setPublic();
		}
	}
	/* добавление в рекомендации*/
	public	function	setFeatured()
	{
		$this->status	=	0;
		$this->save();
	}
	public	function	setStandart()
	{
		$this->is_featured	=	0;
		$this->save();
	}
	public	function	toggleFeatured($value)
	{
		if($value	==	null)
		{
			return$this->setStandart();
		}
		else
		{
			return$this->setFeatured();
		}
	}	
}