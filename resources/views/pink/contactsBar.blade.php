
<div id="sidebar-contact" class="group">
    <div class="widget-first widget contact-info">
        <h3>{{ $contacts->name }} </h3>
        <div class="sidebar-nav">
            <ul>
                <li>
                    <i class="icon-map-marker" style="color:#979797;font-size:20pxpx"></i> {{ Lang::get('ru.Location') }}: {{ $contacts->adress }}
                </li>
                <li>
                    <i class="icon-info-sign" style="color:#979797;font-size:20px">

                    </i> {{ Lang::get('ru.Phone') }}: {{ $contacts->phone }}
                </li>

                <li>
                    <i class="icon-envelope" style="color:#979797;font-size:20px">

                    </i> Email: {{ $contacts->email }}
                </li>
            </ul>
        </div>
    </div>
    <div class="widget-last widget text-image">
        <h3>{{ $contacts->desc }}</h3>
        <div class="text-image" style="text-align:left"><img src="{{ asset(env('THEME')) }}/images/{{ $avatar }}" alt="Customer Support" /></div>
       {!! $contacts->text !!}
    </div>
</div>
