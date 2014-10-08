<?php namespace Snappy;

use Illuminate\Database\Eloquent\Model;

use Hash;
use Snappy\Support\UuidTrait;
use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Model implements UserInterface, RemindableInterface
{
	use UserTrait, RemindableTrait, UuidTrait;

	/**
	 * Indicates if the IDs are auto-incrementing;
	 * 
	 * @var bool
	 */
	public $incrementing = false;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	/**
	 * The attributes that are mass assignable.
	 * 
	 * @var array
	 */
	protected $fillable = ['username', 'password', 'email_address', 'name'];

	/**
	 * Automatically hash the users password when a new one is set.
	 * 
	 * @param  string  $password
	 * @return void
	 */
	public function setPasswordAttribute($password)
	{
		$this->attributes['password'] = Hash::make($password);
	}

	/**
	 * Relationship: Chat
	 * 
	 * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function chats()
	{
		return $this->belongsToMany('Snappy\Chat', 'chat_user', 'chat_id', 'user_id')->withTimestamps();
	}
}
