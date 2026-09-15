@extends('admin.layouts.app')

@section('title', 'About Page Content')

@section('content')

    <x-admin.page-heading title="About Page Content" />

    <form method="POST" action="{{ route('admin.pages.about.update') }}">
        @csrf
        @method('PUT')

        <div class="card mb-4">
            <div class="card-header">Hero Banner</div>
            <div class="card-body">
                <x-admin.input name="hero_eyebrow" label="Eyebrow" :value="$content['hero_eyebrow']" required />
                <div class="row">
                    <div class="col-md-6"><x-admin.input name="hero_title_line1" label="Title line 1" :value="$content['hero_title_line1']" required /></div>
                    <div class="col-md-6"><x-admin.input name="hero_title_line2" label="Title line 2" :value="$content['hero_title_line2']" required /></div>
                </div>
                <x-admin.textarea name="hero_subtitle" label="Subtitle" :value="$content['hero_subtitle']" rows="2" required />
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">Introduction</div>
            <div class="card-body">
                <x-admin.input name="intro_kicker" label="Kicker" :value="$content['intro_kicker']" required />
                <x-admin.input name="intro_title" label="Title" :value="$content['intro_title']" required />
                <x-admin.textarea name="intro_body_1" label="Paragraph 1" :value="$content['intro_body_1']" rows="3" required />
                <x-admin.textarea name="intro_body_2" label="Paragraph 2" :value="$content['intro_body_2']" rows="3" required />
                <div class="row">
                    <div class="col-md-3"><x-admin.input name="stat_1_value" label="Stat 1 value" :value="$content['stat_1_value']" required /></div>
                    <div class="col-md-3"><x-admin.input name="stat_1_label" label="Stat 1 label" :value="$content['stat_1_label']" required /></div>
                    <div class="col-md-3"><x-admin.input name="stat_2_value" label="Stat 2 value" :value="$content['stat_2_value']" required /></div>
                    <div class="col-md-3"><x-admin.input name="stat_2_label" label="Stat 2 label" :value="$content['stat_2_label']" required /></div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Our Values</span>
                <button type="button" class="btn btn-sm btn-outline-dark" id="addValueRow"><i class="bi bi-plus-lg"></i> Add Value</button>
            </div>
            <div class="card-body">
                <x-admin.input name="values_kicker" label="Kicker" :value="$content['values_kicker']" required />
                <x-admin.input name="values_title" label="Title" :value="$content['values_title']" required />

                <label class="form-label mt-3">Value Cards</label>
                <div id="valueRows">
                    @foreach($content['values'] as $value)
                        <div class="row g-2 mb-2 value-row">
                            <div class="col-2"><input type="text" name="value_icon[]" value="{{ $value['icon'] }}" class="form-control form-control-sm" placeholder="bi-trophy"></div>
                            <div class="col-3"><input type="text" name="value_label[]" value="{{ $value['label'] }}" class="form-control form-control-sm" placeholder="Excellence"></div>
                            <div class="col-6"><input type="text" name="value_description[]" value="{{ $value['description'] }}" class="form-control form-control-sm" placeholder="Description"></div>
                            <div class="col-1"><button type="button" class="btn btn-sm btn-outline-danger remove-value-row"><i class="bi bi-x"></i></button></div>
                        </div>
                    @endforeach
                </div>
                <div class="form-text">Icon must be a Bootstrap Icons class name — see icons.getbootstrap.com.</div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">Call To Action Strip</div>
            <div class="card-body">
                <x-admin.input name="cta_title" label="Title" :value="$content['cta_title']" required />
                <x-admin.input name="cta_text" label="Text" :value="$content['cta_text']" required />
                <x-admin.input name="cta_button_text" label="Button text" :value="$content['cta_button_text']" required />
            </div>
        </div>

        <button type="submit" class="btn btn-dark">Save About Page</button>
    </form>

@endsection

@push('scripts')
<script>
    document.getElementById('addValueRow').addEventListener('click', function () {
        const wrap = document.getElementById('valueRows');
        const row = document.createElement('div');
        row.className = 'row g-2 mb-2 value-row';
        row.innerHTML = `
            <div class="col-2"><input type="text" name="value_icon[]" class="form-control form-control-sm" placeholder="bi-trophy"></div>
            <div class="col-3"><input type="text" name="value_label[]" class="form-control form-control-sm" placeholder="Excellence"></div>
            <div class="col-6"><input type="text" name="value_description[]" class="form-control form-control-sm" placeholder="Description"></div>
            <div class="col-1"><button type="button" class="btn btn-sm btn-outline-danger remove-value-row"><i class="bi bi-x"></i></button></div>
        `;
        wrap.appendChild(row);
    });

    document.getElementById('valueRows').addEventListener('click', function (e) {
        if (e.target.closest('.remove-value-row')) {
            e.target.closest('.value-row').remove();
        }
    });
</script>
@endpush
