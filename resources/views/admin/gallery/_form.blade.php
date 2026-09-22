@csrf

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <x-admin.file name="image" label="Image" :current="$galleryItem->image" />
                <x-admin.input name="caption" label="Caption" :value="$galleryItem->caption" />
                <x-admin.select name="event_id" label="Related Event" :value="$galleryItem->event_id" :options="$events" placeholder="No specific event" />
                <x-admin.select name="category_id" label="Category" :value="$galleryItem->category_id" :options="$categories" placeholder="No category" />
                <a href="{{ route('admin.gallery-categories.index') }}" class="small">Manage categories &rarr;</a>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <x-admin.input name="sort_order" label="Sort Order" type="number" :value="$galleryItem->sort_order" />
                <x-admin.checkbox name="is_featured" label="Show as large/featured tile" :checked="$galleryItem->is_featured ?? false" />
                <button type="submit" class="btn btn-dark w-100 mt-2">Save Gallery Item</button>
            </div>
        </div>
    </div>
</div>
