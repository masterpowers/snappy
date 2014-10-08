<?php namespace Snappy;

use Snappy\Support\UuidTrait;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
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
    protected $table = 'messages';

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
    protected $fillable = ['user_id', 'chat_id', 'type', 'content'];

    /**
     * Relationship: Author
     * 
     * @return  Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo('Snappy\User', 'user_id');
    }
}