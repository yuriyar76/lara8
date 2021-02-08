<?
   //dump($items);
?>
@if(!empty($items))
@foreach($items as $item)
<li id="li-comment-{{ $item->id }}" class="comment even {{ ($item->user_id == $article->user_id) ? 'bypostauthor odd' : ''}}">
    <div id="comment-{{ $item->id }}" class="comment-container">
        <div class="comment-author vcard">
            <img alt="" src="{{ asset(env('THEME')) }}/images/avatar/unknow.png" class="avatar" height="75" width="75" />
            <cite class="fn">{{ ($item->user->name)? $item->user->name : $item->name }}</cite>
        </div>
        <!-- .comment-author .vcard -->
        <div class="comment-meta commentmetadata">
            <div class="intro">
                <div class="commentDate">
                    <a href="">
                        {{ is_object($item->created_at) ? $item->created_at->format('F d, Y \a\t H:i') : '' }}
                    </a>
                </div>
                <div class="commentNumber"></div>
            </div>
            <div class="comment-body">
               <p>{{ $item->text }}</p>
            </div>
            <div class="reply group">
                <a class="comment-reply-link" href="#respond" onclick="return addComment.moveForm(&quot;comment-{{ $item->id }}&quot;, &quot;{{ $item->id }}&quot;, &quot;respond&quot;, &quot;{{ $item->article_id }}&quot;)">Reply</a>
            </div>
            <!-- .reply -->
        </div>
        <!-- .comment-meta .commentmetadata -->
    </div>
    <!-- #comment-##  -->
    @if(isset($com[$item->id]))
        <ul class="children">
            @include(env('THEME').'.include.comment', ['items'=>$com[$item->id]])
        </ul>
    @endif

</li>
@endforeach
@else
    <div class="nocomments">
        <h2>Нет комментариев</h2>
    </div>
@endif
