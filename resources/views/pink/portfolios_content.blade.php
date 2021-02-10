<!-- START CONTENT -->
<div id="content-page" class="content group">
    <div class="hentry group">

        <div id="portfolio" class="portfolio-big-image">
            @foreach($portfolios as $portfolio)
            <div class="hentry work group">
                <div class="work-thumbnail">
                    <div class="nozoom">
                        <img src="{{ env('THEME') }}/images/projects/{{ $portfolio->img->max }}" alt="0061" title="{{ $portfolio->title }}" />
                        <div class="overlay">
                            <a class="overlay_img" href="{{ env('THEME') }}/images/projects/{{ $portfolio->img->path }}" rel="lightbox" title="{{ $portfolio->title }}"></a>
                            <a class="overlay_project" href="{{ route('portfolios.show', ['alias'=>$portfolio->alias]) }}"></a>
                            <span class="overlay_title">{{ $portfolio->title }}</span>
                        </div>
                    </div>
                </div>
                <div class="work-description">
                    <h3>{{ $portfolio->title }}</h3>
                      {!! Str::limit($portfolio->text, 200) !!}
                    <div class="clear"></div>
                    <div class="work-skillsdate">
                        <p class="skills"><span class="label">Skills:</span> {{ $portfolio->filter->title }}</p>
                    </div>
                    <a class="read-more" href="{{ route('portfolios.show', ['alias'=>$portfolio->alias]) }}">
                        {{ Lang::get('ru.view_portfolio') }}
                    </a>
                </div>
                <div class="clear"></div>
            </div>
            @endforeach
                <div class="general-pagination group">
                    {{ $portfolios->links() }}
                </div>

        </div>
        <div class="clear"></div>
    </div>

</div>
<!-- END CONTENT -->
