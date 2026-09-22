@csrf

<div class="card">
    <div class="card-body">
        <x-admin.input name="name" label="Category Name" :value="$speakerCategory->name" required />
        <x-admin.input name="sort_order" label="Sort Order" type="number" :value="$speakerCategory->sort_order ?? 0" />
        <x-admin.checkbox name="is_home_featured" label="Show this category's speakers on the homepage" :checked="$speakerCategory->is_home_featured ?? false" />
        <button type="submit" class="btn btn-dark mt-2">Save Category</button>
    </div>
</div>
