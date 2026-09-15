@csrf

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <x-admin.input name="name" label="Name" :value="$award->name" required />
                <x-admin.input name="slug" label="Slug" :value="$award->slug" help="Leave blank to auto-generate from the name." />
                <x-admin.input name="icon" label="Bootstrap Icon Class" :value="$award->icon" required help="e.g. bi-trophy — see icons.getbootstrap.com" />
                <x-admin.input name="short_description" label="Short Description" :value="$award->short_description" help="Shown on category cards." />
                <x-admin.textarea name="long_description" label="Long Description" :value="$award->long_description" rows="4" help="Shown on the category's detail page." />
                <x-admin.file name="image" label="Image" :current="$award->image" />
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <x-admin.input name="sort_order" label="Sort Order" type="number" :value="$award->sort_order" />
                <button type="submit" class="btn btn-dark w-100 mt-2">Save Award Category</button>
            </div>
        </div>
    </div>
</div>
