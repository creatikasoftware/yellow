@csrf

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <x-admin.file name="image" label="Background Image" :current="$heroSlide->image" help="Required. Shown full-width behind the slide's text." />
                <x-admin.input name="eyebrow" label="Eyebrow" :value="$heroSlide->eyebrow" help="Optional small label above the title, e.g. WELCOME TO" />
                <x-admin.input name="title" label="Title" :value="$heroSlide->title" help="Optional. Leave every text field on this slide blank to show the image alone, with no text overlay." />
                <x-admin.textarea name="subtitle" label="Subtitle" :value="$heroSlide->subtitle" rows="2" />
                <div class="row">
                    <div class="col-md-6"><x-admin.input name="button_text" label="Button Text" :value="$heroSlide->button_text" help="Optional, e.g. Register Now" /></div>
                    <div class="col-md-6"><x-admin.input name="button_url" label="Button Link" :value="$heroSlide->button_url" help="e.g. /registration" /></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <x-admin.input name="sort_order" label="Sort Order" type="number" :value="$heroSlide->sort_order ?? 0" />
                <button type="submit" class="btn btn-dark w-100 mt-2">Save Slide</button>
            </div>
        </div>
    </div>
</div>
