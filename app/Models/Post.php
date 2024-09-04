<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * Class Post
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['title', 'description'];

    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('deleted_at');
    }
}
