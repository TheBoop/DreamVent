<?php
namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class AccountFrontPage extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];
    protected $casts = [
        'user_id' => 'int',
    ];
    /**
     * Get the user that owns the task.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}