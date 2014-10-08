<?php namespace Snappy;

use Snappy\Support\UuidTrait;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use UuidTrait;

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
    protected $table = 'chats';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that are mass assignable.
     * 
     * @var array
     */
    protected $fillable = ['user_id'];

    /**
     * Relationship: Recipients
     * 
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function recipients()
    {
        return $this->belongsToMany('Snappy\User', 'chat_user', 'chat_id', 'user_id')->withTimestamps();
    }

    /**
     * Relationship: Messages
     * 
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany('Snappy\Message');
    }
}
