<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class tag extends Model
{
	use Sluggable;
    public function posts()
	{
		return $this->beelongsToMany(
		Post::class,
			'post_tags',
			'tag_id',
			'post_id'
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