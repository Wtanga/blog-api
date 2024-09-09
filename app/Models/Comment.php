<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * Class Comment
 *
 * @property int $id
 * @property string $text
 * @property int $post_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @method static paginate(int $PER_PAGE)
 */
class Comment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['text', 'post_id'];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
