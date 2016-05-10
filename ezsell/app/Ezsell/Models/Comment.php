<?php

namespace App\Ezsell\Models;

class Comment extends Model {
	protected $guarded = [ 
			'id' 
	];
	protected $fillable = [ 
			'id',
			'item_id',
			'parent_id',
			'text',
			'options' 
	];
	protected $hidden = [ ];
	protected $dates = [ 
			'created_at',
			'updated_at',
			'deleted_at' 
	];
	protected $casts = [ 
			'options' => 'array' 
	];
	public function item() {
		return $this->belongsTo ( 'App\Ezsell\Models\Item', 'item_id', 'id' );
	}
	public function parent() {
		return $this->belongsTo ( 'App\Ezsell\Models\Comment', 'parent_id', 'id' );
	}
	public function children() {
		return $this->hasMany ( 'App\Ezsell\Models\Comment', 'parent_id', 'id' );
	}
}
