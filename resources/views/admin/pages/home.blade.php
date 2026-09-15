@extends('admin.layouts.app')

@section('title', 'Home Page Content')

@section('content')

    <x-admin.page-heading title="Home Page Content" />

    <form method="POST" action="{{ route('admin.pages.home.update') }}">
        @csrf
        @method('PUT')

        <div class="card mb-4">
            <div class="card-header">Hero Banner</div>
            <div class="card-body">
                <x-admin.input name="hero_eyebrow" label="Eyebrow" :value="$content['hero_eyebrow']" required />
                <div class="row">
                    <div class="col-md-4"><x-admin.input name="hero_title_line1" label="Title (before highlight)" :value="$content['hero_title_line1']" required /></div>
                    <div class="col-md-4"><x-admin.input name="hero_title_highlight" label="Highlighted word" :value="$content['hero_title_highlight']" required help="Shown in gold." /></div>
                    <div class="col-md-4"><x-admin.input name="hero_title_line2" label="Title (after highlight)" :value="$content['hero_title_line2']" required /></div>
                </div>
                <x-admin.textarea name="hero_subtitle" label="Subtitle" :value="$content['hero_subtitle']" rows="2" required />
                <div class="row">
                    <div class="col-md-6"><x-admin.input name="hero_cta_primary" label="Primary button text" :value="$content['hero_cta_primary']" required /></div>
                    <div class="col-md-6"><x-admin.input name="hero_cta_secondary" label="Secondary button text" :value="$content['hero_cta_secondary']" required /></div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">About Teaser</div>
            <div class="card-body">
                <x-admin.input name="about_kicker" label="Kicker" :value="$content['about_kicker']" required />
                <x-admin.input name="about_title" label="Title" :value="$content['about_title']" required />
                <x-admin.textarea name="about_body" label="Body" :value="$content['about_body']" rows="3" required />
                <x-admin.input name="about_cta_text" label="Button text" :value="$content['about_cta_text']" required />
                <x-admin.textarea name="info_box_items" label="Info Box Items" :value="implode(PHP_EOL, $content['info_box_items'])" rows="4" help="One item per line — shown as the 4 bullet points beside the About teaser." required />
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">Section Headings</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6"><x-admin.input name="events_kicker" label="Events — Kicker" :value="$content['events_kicker']" required /></div>
                    <div class="col-md-6"><x-admin.input name="events_title" label="Events — Title" :value="$content['events_title']" required /></div>
                    <div class="col-md-6"><x-admin.input name="awards_kicker" label="Awards — Kicker" :value="$content['awards_kicker']" required /></div>
                    <div class="col-md-6"><x-admin.input name="awards_title" label="Awards — Title" :value="$content['awards_title']" required /></div>
                    <div class="col-md-6"><x-admin.input name="speakers_kicker" label="Speakers — Kicker" :value="$content['speakers_kicker']" required /></div>
                    <div class="col-md-6"><x-admin.input name="speakers_title" label="Speakers — Title" :value="$content['speakers_title']" required /></div>
                    <div class="col-md-6"><x-admin.input name="gallery_kicker" label="Gallery — Kicker" :value="$content['gallery_kicker']" required /></div>
                    <div class="col-md-6"><x-admin.input name="gallery_title" label="Gallery — Title" :value="$content['gallery_title']" required /></div>
                    <div class="col-md-6"><x-admin.input name="partners_kicker" label="Partners — Kicker" :value="$content['partners_kicker']" required /></div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">Registration Widget (only shown when an event is marked "Feature on homepage")</div>
            <div class="card-body">
                <x-admin.input name="registration_eyebrow" label="Eyebrow" :value="$content['registration_eyebrow']" required />
                <div class="row">
                    <div class="col-md-6"><x-admin.input name="registration_title_line1" label="Title" :value="$content['registration_title_line1']" required /></div>
                    <div class="col-md-6"><x-admin.input name="registration_title_highlight" label="Highlighted phrase" :value="$content['registration_title_highlight']" required help="Shown in gold." /></div>
                </div>
                <x-admin.textarea name="registration_subtitle" label="Subtitle" :value="$content['registration_subtitle']" rows="2" required />
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">Testimonials (only shown when a testimonial is marked "Featured")</div>
            <div class="card-body">
                <x-admin.input name="testimonials_eyebrow" label="Eyebrow" :value="$content['testimonials_eyebrow']" required />
                <div class="row">
                    <div class="col-md-6"><x-admin.input name="testimonials_title_line1" label="Title" :value="$content['testimonials_title_line1']" required /></div>
                    <div class="col-md-6"><x-admin.input name="testimonials_title_highlight" label="Highlighted phrase" :value="$content['testimonials_title_highlight']" required /></div>
                </div>
                <x-admin.textarea name="testimonials_subtitle" label="Subtitle" :value="$content['testimonials_subtitle']" rows="2" required />
            </div>
        </div>

        <button type="submit" class="btn btn-dark">Save Home Page</button>
    </form>

@endsection
