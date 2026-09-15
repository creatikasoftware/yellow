@csrf

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <x-admin.input name="title" label="Title" :value="$newsArticle->title" required />
                <x-admin.input name="slug" label="Slug" :value="$newsArticle->slug" help="Leave blank to auto-generate from the title." />
                <x-admin.input name="excerpt" label="Excerpt" :value="$newsArticle->excerpt" help="Short teaser shown on the news listing." />
                <x-admin.textarea name="body" label="Body" :value="$newsArticle->body" rows="8" help="Separate paragraphs with a blank line." />
                <x-admin.file name="image" label="Image" :current="$newsArticle->image" />
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <x-admin.input name="published_at" label="Published Date" type="date" :value="optional($newsArticle->published_at)->format('Y-m-d')" required />
                <button type="submit" class="btn btn-dark w-100 mt-2">Save Article</button>
            </div>
        </div>
    </div>
</div>
