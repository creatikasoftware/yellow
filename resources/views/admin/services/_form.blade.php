@csrf

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header">Service Details</div>
            <div class="card-body">
                <x-admin.input name="title" label="Service Title" :value="$service->title" required />
                <x-admin.input name="slug" label="Slug" :value="$service->slug" help="Leave blank to auto-generate from the title. Letters, numbers and hyphens only." />
                <x-admin.input name="short_description" label="Short Description" :value="$service->short_description" help="Shown on service cards and as the SEO fallback description." />
                <x-admin.textarea name="description" label="Full Description" :value="$service->description" rows="8" />
                <x-admin.file name="featured_image" label="Featured Image" :current="$service->featured_image" help="JPEG, PNG or WEBP, up to 2MB." />
                <x-admin.input name="icon" label="Icon" :value="$service->icon" help="A Bootstrap Icons class name, e.g. bi-calendar-event — see icons.getbootstrap.com" />
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">SEO</div>
            <div class="card-body">
                <x-admin.input name="meta_title" label="SEO Title" :value="$service->meta_title" help="Falls back to the service title when left blank." />
                <x-admin.textarea name="meta_description" label="SEO Description" :value="$service->meta_description" rows="2" help="Falls back to the short description when left blank." />
                <x-admin.input name="meta_keywords" label="SEO Keywords" :value="$service->meta_keywords" help="Comma-separated." />
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <x-admin.input name="sort_order" label="Sort Order" type="number" :value="$service->sort_order ?? 0" />
                <x-admin.checkbox name="status" label="Published" :checked="$service->exists ? $service->status : true" />
                <x-admin.checkbox name="featured" label="Feature this service" :checked="$service->featured ?? false" />
                <button type="submit" class="btn btn-dark w-100 mt-2">Save Service</button>
            </div>
        </div>
    </div>
</div>
