<?php

namespace App\Observers;

use App\Models\NewsArticle;

class NewsArticleObserver
{
    /**
     * Handle the NewsArticle "saving" event.
     *
     * @param \App\Models\NewsArticle $NewsArticle
     *
     * @return void
     */
    public function saving(NewsArticle $NewsArticle)
    {
        $NewsArticle->user_id = $NewsArticle->user_id ?: optional(currentUser(request()->user()))->id;
    }
}
