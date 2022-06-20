<li>
    <a href="{{route('news_articles')}}">
        <span data-key="t-calendar">{{\App\Models\NewsArticle::crudTrans('index')}}</span>
    </a>
    @if(request()->routeIs('news_articles.edit'))
    <a onclick="event.preventDefault(); return false" href="{{route('news_articles.edit',['news_article'=>request()->news_article])}}">
        <span data-key="t-chat"></span>
    </a>
    @endif
</li>
