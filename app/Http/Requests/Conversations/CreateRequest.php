<?php
/**
 * Topic create request.
 *
 * @version 2.0.0
 * @author  MyBB Group
 * @license LGPL v3
 */

namespace MyBB\Core\Http\Requests\Conversations;

use MyBB\Auth\Contracts\Guard;
use MyBB\Core\Http\Requests\Request;
use MyBB\Core\Permissions\PermissionChecker;

class CreateRequest extends Request
{
	/** @var Guard $guard */
	private $guard;

	/**
	 * @param Guard $guard
	 */
	public function __construct(Guard $guard)
	{
		$this->guard = $guard;
	}

	/**
	 * @return array
	 */
	public function rules()
	{
		return [
			'participants' => 'required', // TODO: validate the names
			'message' => 'required',
			'title' => 'required',
		];
	}

	/**
	 * @return bool
	 */
	public function authorize()
	{
		//return $this->guard->check();
		return true; // TODO: In dev return, needs replacing for later...
	}
}
