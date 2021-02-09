
<div class="singl-services text-center mb-60">
    <div class="top-caption">
        <h4><a class="event-link" href="{{ $event->link }}">{{ $event->name }}</a></h4>
        <p>{{ $event->starts->toFormattedDateString() }} - {{ $event->ends->toFormattedDateString() }}</p>
    </div>
    <div class="services-img">
        <img style="width: 237px; height: 237px" src="{{ $event->feature_img }}" alt="">
        <div class="back-flower">   
            <img src="/assets/img/service/services_flower1.png" alt="">
        </div>
    </div>
    <div class="bottom-caption">
        <span>{{ $event->starts->toTimeString() }}-{{ $event->ends->toTimeString() }}</span>
        <p>{{ $event->location->name }}<br> {{ $event->location->address }}</p>
    </div>
</div>