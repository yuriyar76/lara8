
<div id="content-page" class="content group">
    <div class="clear"></div>
    <div class="posts">
        <div class="group portfolio-post internal-post">
            <div id="portfolio" class="portfolio-full-description">

                <div class="fulldescription_title gallery-filters">
                    <h1>{{ $portfolio->title }}</h1>
                </div>

                <div class="portfolios hentry work group">
                    <div class="work-thumbnail">
                        <a class="thumb"><img src="{{ asset(env('THEME')) }}/images/projects/{{ $portfolio->img->max }}" alt="0081" title="0081" /></a>
                    </div>
                    <div class="work-description">
                        {!! $portfolio->text !!}
                        <div class="clear"></div>
                        <div class="work-skillsdate">
                            <p class="skills"><span class="label">{{ Lang::get('ru.Skills') }}:</span> {{ $portfolio->filter->title }}</p>
                            <p class="workdate"><span class="label">{{ Lang::get('ru.Customer') }}:</span>{{ $portfolio->customer }}</p>
                            <p class="workdate"><span class="label">{{ Lang::get('ru.Year') }}:</span> {{ $portfolio->created_at->format('Y') }}</p>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>

                <div class="clear"></div>

                <h3>{{ Lang::get('ru.Other_Projects') }}</h3>

                <div class="portfolio-full-description-related-projects">
                    @set($alias_p, $portfolio->alias)
                    @foreach($portfolios as $project)
                        @if($project->alias == $alias_p)
                            @continue
                        @endif
                    <div class="related_project">
                        <a class="related_proj related_img" href="{{ route('portfolios.show', ['alias'=>$project->alias]) }}" title="{{ $project->title }}">
                            <img src="{{ asset(env('THEME')) }}/images/projects/{{ $project->img->mini }}" alt="0061" title="0061" /></a>
                        <h4><a href="{{ route('portfolios.show', ['alias'=>$project->alias]) }}">{{ $project->title }}</a></h4>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>
