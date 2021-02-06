
    <div class="widget-first widget recent-posts">
        <h3>{{ Lang::get('ru.recent_post') }}</h3>
        <div class="recent-post group">
                @foreach($portfolios as $portfolio)
                <div class="hentry-post group">
                    <div class="thumb-img"><img style="width:55px;" src="{{ asset(env('THEME')) }}/images/projects/{{ $portfolio->img->mini }}" alt="001" title="001" /></div>
                    <div class="text">
                        <a href="{{ route('portfolios.show', ['alias'=>$portfolio->alias]) }}" title="{{ $portfolio->title }}" class="title">{{ $portfolio->title }}</a>
                        <p>{{ Str::limit($portfolio->text, 50) }}</p>
                        <a class="read-more" href="{{ route('portfolios.show', ['alias'=>$portfolio->alias]) }}">&rarr; {{ Lang::get('ru.read_more') }}</a>
                    </div>
                </div>
                @endforeach


        </div>
    </div>


    <div class="widget-last widget recent-comments">
        <h3>{{ Lang::get('ru.recent_comments') }}</h3>
        <div class="recent-post recent-comments group">
            @foreach($comments as $comment)
                <div class="the-post group">
                    <div class="avatar">
                        <img alt="" src="{{ asset(env('THEME')) }}/images/avatar/unknow55.png" class="avatar" />
                    </div>
                    <span class="author"><strong><a href="">{{ isset($comment->user->name) ? $comment->user->name : $comments->name }}</a></strong> in</span>
                    <a class="title" href="{{ route('articles.show', ['alias'=>$comment->article->alias]) }}">  {{ $comment->article->title  }}</a>
                    <p class="comment">
                       {{ Str::limit($comment->text, 50) }} <a class="goto" href="">&#187;</a>
                    </p>
                </div>
            @endforeach

        </div>
    </div>
