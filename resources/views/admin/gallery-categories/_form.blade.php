@csrf

<div class="card">
    <div class="card-body">
        <x-admin.input name="name" label="Category Name" :value="$galleryCategory->name" required />
        <button type="submit" class="btn btn-dark mt-2">Save Category</button>
    </div>
</div>
