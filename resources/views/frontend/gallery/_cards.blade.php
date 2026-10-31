@foreach($items as $item)
    <div class="col-6 col-md-4"><x-gallery-card :item="$item" /></div>
@endforeach
