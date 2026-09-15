@csrf

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <x-admin.input name="name" label="Name" :value="$partner->name" required help="Shown as text if no logo is uploaded." />
                <x-admin.input name="website_url" label="Website URL" :value="$partner->website_url" type="url" />
                <x-admin.file name="logo" label="Logo" :current="$partner->logo" />
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <x-admin.input name="sort_order" label="Sort Order" type="number" :value="$partner->sort_order" />
                <button type="submit" class="btn btn-dark w-100 mt-2">Save Partner</button>
            </div>
        </div>
    </div>
</div>
