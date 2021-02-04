<div id="content-blog" class="content group">
   @if($articles)
       @foreach($articles as $article)
         {{--  {!! dump($article) !!}--}}
            <div class="sticky hentry hentry-post blog-big group">
                <!-- post featured & title -->
                <div class="thumbnail">
                    <!-- post title -->
                    <h2 class="post-title"><a href="{{ route('articles.show', ['alias'=>$article->alias]) }}">{{ $article->title }}</a></h2>
                    <!-- post featured -->
                    <div class="image-wrap">
                        <img src="{{ asset(env('THEME')) }}/images/articles/{{ $article->img->max }}" alt="001" title="001" />
                    </div>
                    <p class="date">
                        <span class="month">@if($article->created_at){{ $article->created_at->format('M')}}@endif </span>
                        <span class="day">@if($article->created_at){{ $article->created_at->format('d')}}@endif</span>
                    </p>
                </div>
                <!-- post meta -->
                <div class="meta group">
                    <p class="author"><span>by <a href="#" title="Posts by {{ $article->user->name }}" rel="author">{{ $article->user->name }}</a></span></p>
                    <p class="categories"><span>In: <a href="{{ route('articlesCat', ['cat_alias'=>$article->category->alias]) }}" title="View all posts in {{ $article->category->title }}" rel="category tag">{{ $article->category->title }}</a>
                           </span></p>
                    <p class="comments"><span><a href="{{ route('articles.show', ['alias'=>$article->alias]) }}#respond" title="Comment on Section shortcodes &amp; sticky posts!">{{ count($article->comment) ? count($article->comment) : '0' }}
                                                       {{ Lang::choice('ru.comments',  count($article->comment) ? count($article->comment) : '0') }}</a></span></p>
                </div>
                <!-- post content -->
                <div class="the-content group">
                    <p>{!!  $article->desc !!}</p>
                    <p><a href="{{ route('articles.show', ['alias'=>$article->alias]) }}" class="btn
                    btn-beetle-bus-goes-jamba-juice-4 btn-more-link">→ {{ Lang::get('ru.readmore') }}</a></p>
                </div>
                <div class="clear"></div>
            </div>
       @endforeach
           <div class="general-pagination group">
               {{ $articles->links() }}
           </div>
    @else
       <h2>{{ Lang::get('ru.no_articles') }}</h2>
    @endif
</div>
