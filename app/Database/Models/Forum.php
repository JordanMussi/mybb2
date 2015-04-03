<?php
/**
 * Forum model class.
 *
 * @version 2.0.0
 * @author  MyBB Group
 * @license LGPL v3
 */

namespace MyBB\Core\Database\Models;

use MyBB\Core\Traits\Permissionable;
use Kalnoy\Nestedset\Node;
use McCool\LaravelAutoPresenter\HasPresenter;

class Forum extends Node implements HasPresenter
{
	use Permissionable;

	/**
	 * Nested set column IDs.
	 */
	const LFT       = 'left_id';
	const RGT       = 'right_id';
	const PARENT_ID = 'parent_id';
	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'forums';
	/**
	 * The relations to eager load on every query.
	 *
	 * @var array
	 */
	protected $with = array();
	/**
	 * The attributes that aren't mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['left_id', 'right_id', 'parent_id'];

	private static function getContentName()
	{
		return 'forum';
	}

	/**
	 * Get the presenter class.
	 *
	 * @return string
	 */
	public function getPresenterClass()
	{
		return 'MyBB\Core\Presenters\Forum';
	}

	/**
	 * A forum contains many threads.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function topics()
	{
		return $this->hasMany('MyBB\\Core\\Database\\Models\\Topic');
	}

	/**
	 * A forum contains many posts, through its threads.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
	 */
	public function posts()
	{
		return $this->hasManyThrough('MyBB\\Core\\Database\\Models\\Post', 'MyBB\\Core\\Database\\Models\\Topic');
	}

	/**
	 * A forum has a single last post.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function lastPost()
	{
		return $this->hasOne('MyBB\\Core\\Database\\Models\\Post', 'id', 'last_post_id');
	}

	/**
	 * A forum has a single last post author.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function lastPostAuthor()
	{
		return $this->hasOne('MyBB\\Core\\Database\\Models\\User', 'id', 'last_post_user_id');
	}
}
