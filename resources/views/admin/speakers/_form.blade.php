@csrf

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <x-admin.input name="name" label="Name" :value="$speaker->name" required />
                <x-admin.input name="slug" label="Slug" :value="$speaker->slug" help="Leave blank to auto-generate from the name." />
                <x-admin.input name="role" label="Role" :value="$speaker->role" help="Shown on speaker cards, e.g. Business Leader" />
                <x-admin.input name="tagline" label="Tagline" :value="$speaker->tagline" help="Shown on the profile page, e.g. Business Leader · Keynote Speaker · Mentor" />
                <x-admin.textarea name="bio" label="Biography" :value="$speaker->bio" rows="4" />
                <x-admin.textarea name="expertise" label="Areas of Expertise" :value="$speaker->expertise ? implode(PHP_EOL, $speaker->expertise) : null" rows="3" help="One per line." />
                <x-admin.file name="photo" label="Photo" :current="$speaker->photo" />
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <x-admin.input name="sort_order" label="Sort Order" type="number" :value="$speaker->sort_order" />
                <button type="submit" class="btn btn-dark w-100 mt-2">Save Speaker</button>
            </div>
        </div>
    </div>
</div>
