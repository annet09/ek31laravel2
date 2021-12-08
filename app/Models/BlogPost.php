<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogPost extends Model
{


    use HasFactory;
    use SoftDeletes;

    const UNKNOWN_USER = 0;
    protected $fillable
        = [
            'title',
            'slug',
            'category_id',
            'excerpt',
            'content_raw',
            'is_published',
            'published_at',
            'user_id',
        ];

    /**
     * Категорія статті
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        //стаття належить категорії
        return $this->belongsTo(BlogCategory::class);
    }

    /**
     * Автор статті
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        //стаття належить користувачу
        return $this->belongsTo(User::class);
    }
    /**
     * Обробка перед створенням запису.
     *
     * @param  BlogPost  $blogPost
     *
     */
    public function creating(BlogPost $blogPost)
    {
        $this->setPublishedAt($blogPost);

        $this->setSlug($blogPost);

        $this->setHtml($blogPost);

        $this->setUser($blogPost);
    }

    /**
     * Встановлюємо значення полю content_html з поля content_raw.
     *
     * @param BlogPost $blogPost
     */
    protected function setHtml(BlogPost $blogPost)
    {
        if ($blogPost->isDirty('content_raw')) {
            //Тут треба зробити генерацію markdown -> html
            $blogPost->content_html = $blogPost->content_raw;
        }
    }

    /**
     * Якщо user_id не вказано, то встановимо юзера 1.
     *
     * @param BlogPost $blogPost
     */
    protected function setUser(BlogPost $blogPost)
    {

        $blogPost->user_id = auth()->id() ?? BlogPost::UNKNOWN_USER;

    }

}
