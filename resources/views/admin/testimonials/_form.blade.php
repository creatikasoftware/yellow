@csrf

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <x-admin.input name="name" label="Name" :value="$testimonial->name" required />
                <x-admin.input name="role_company" label="Role / Company" :value="$testimonial->role_company" help="e.g. CEO, FinEdge Capital" />
                <x-admin.textarea name="quote" label="Quote" :value="$testimonial->quote" rows="4" required />
                <x-admin.input name="avatar_initials" label="Avatar Initials" :value="$testimonial->avatar_initials" help="Shown when no photo is uploaded, e.g. AM" />
                <x-admin.file name="photo" label="Photo" :current="$testimonial->photo" />
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <x-admin.select name="rating" label="Rating" :value="$testimonial->rating ?? 5" :options="[1=>'1',2=>'2',3=>'3',4=>'4',5=>'5']" required />
                <x-admin.input name="sort_order" label="Sort Order" type="number" :value="$testimonial->sort_order" />
                <x-admin.checkbox name="is_featured" label="Feature as the large testimonial" :checked="$testimonial->is_featured ?? false" />
                <button type="submit" class="btn btn-dark w-100 mt-2">Save Testimonial</button>
            </div>
        </div>
    </div>
</div>
