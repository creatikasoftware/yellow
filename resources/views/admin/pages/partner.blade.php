@extends('admin.layouts.app')

@section('title', 'Partner With Us Page Content')

@section('content')

    <x-admin.page-heading title="Partner With Us Page Content" />

    <form method="POST" action="{{ route('admin.pages.partner.update') }}">
        @csrf
        @method('PUT')

        <div class="card mb-4">
            <div class="card-header">Hero Banner</div>
            <div class="card-body">
                <x-admin.input name="hero_eyebrow" label="Eyebrow" :value="$content['hero_eyebrow']" required />
                <x-admin.input name="hero_title" label="Title" :value="$content['hero_title']" required />
                <x-admin.textarea name="hero_subtitle" label="Subtitle" :value="$content['hero_subtitle']" rows="3" required />
                <div class="row">
                    <div class="col-md-6"><x-admin.input name="hero_cta_primary" label="Primary Button Text" :value="$content['hero_cta_primary']" required help="Links to the application form on this page." /></div>
                    <div class="col-md-6"><x-admin.input name="hero_cta_secondary" label="Secondary Button Text" :value="$content['hero_cta_secondary']" required help="Links to the Partnership Tiers list below." /></div>
                </div>
                <x-admin.textarea name="tags" label="Audience Tags" :value="implode(PHP_EOL, $content['tags'])" rows="4" required help="One per line, e.g. Event Companies" />
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Stats</span>
                <button type="button" class="btn btn-sm btn-outline-dark" id="addStatRow"><i class="bi bi-plus-lg"></i> Add Stat</button>
            </div>
            <div class="card-body">
                <div id="statRows">
                    @foreach($content['stats'] as $stat)
                        <div class="row g-2 mb-2 stat-row">
                            <div class="col-5"><input type="text" name="stat_value[]" value="{{ $stat['value'] }}" class="form-control form-control-sm" placeholder="500+"></div>
                            <div class="col-6"><input type="text" name="stat_label[]" value="{{ $stat['label'] }}" class="form-control form-control-sm" placeholder="Active Partners"></div>
                            <div class="col-1"><button type="button" class="btn btn-sm btn-outline-danger remove-stat-row"><i class="bi bi-x"></i></button></div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">Testimonial</div>
            <div class="card-body">
                <x-admin.input name="testimonial_kicker" label="Kicker" :value="$content['testimonial_kicker']" required />
                <x-admin.textarea name="testimonial_quote" label="Quote" :value="$content['testimonial_quote']" rows="3" required />
                <x-admin.input name="testimonial_author" label="Author" :value="$content['testimonial_author']" required help="e.g. Name, Role, City" />
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">Application Form</div>
            <div class="card-body">
                <x-admin.input name="form_title" label="Form Title" :value="$content['form_title']" required />
                <x-admin.input name="form_subtitle" label="Form Subtitle" :value="$content['form_subtitle']" required />
                <x-admin.textarea name="tiers" label="Partnership Tiers" :value="implode(PHP_EOL, $content['tiers'])" rows="4" required help="One per line — populates the 'Partnership Tier of Interest' dropdown." />
            </div>
        </div>

        <button type="submit" class="btn btn-dark">Save Partner Page</button>
    </form>

@endsection

@push('scripts')
<script>
    document.getElementById('addStatRow').addEventListener('click', function () {
        const wrap = document.getElementById('statRows');
        const row = document.createElement('div');
        row.className = 'row g-2 mb-2 stat-row';
        row.innerHTML = `
            <div class="col-5"><input type="text" name="stat_value[]" class="form-control form-control-sm" placeholder="500+"></div>
            <div class="col-6"><input type="text" name="stat_label[]" class="form-control form-control-sm" placeholder="Active Partners"></div>
            <div class="col-1"><button type="button" class="btn btn-sm btn-outline-danger remove-stat-row"><i class="bi bi-x"></i></button></div>
        `;
        wrap.appendChild(row);
    });

    document.getElementById('statRows').addEventListener('click', function (e) {
        if (e.target.closest('.remove-stat-row')) {
            e.target.closest('.stat-row').remove();
        }
    });
</script>
@endpush
