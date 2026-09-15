@extends('admin.layouts.app')

@section('title', 'Contact Page Content')

@section('content')

    <x-admin.page-heading title="Contact Page Content" />

    <form method="POST" action="{{ route('admin.pages.contact.update') }}">
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
            <div class="card-header">Get In Touch Heading</div>
            <div class="card-body">
                <x-admin.input name="intro_kicker" label="Kicker" :value="$content['intro_kicker']" required />
                <x-admin.input name="intro_title" label="Title" :value="$content['intro_title']" required />
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">Contact Details &amp; Footer</div>
            <div class="card-body">
                <div class="form-text mb-3">These also appear in the footer on every page.</div>
                <x-admin.input name="contact_address" label="Address" :value="$site['contact_address']" required />
                <div class="row">
                    <div class="col-md-6"><x-admin.input name="contact_phone" label="Phone" :value="$site['contact_phone']" required /></div>
                    <div class="col-md-6"><x-admin.input name="contact_email" label="Email" type="email" :value="$site['contact_email']" required /></div>
                </div>
                <x-admin.textarea name="footer_copy" label="Footer Tagline" :value="$site['footer_copy']" rows="2" required />
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">Social Links (used in the footer)</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6"><x-admin.input name="social_facebook" label="Facebook URL" :value="$site['social_facebook']" /></div>
                    <div class="col-md-6"><x-admin.input name="social_twitter" label="X / Twitter URL" :value="$site['social_twitter']" /></div>
                    <div class="col-md-6"><x-admin.input name="social_linkedin" label="LinkedIn URL" :value="$site['social_linkedin']" /></div>
                    <div class="col-md-6"><x-admin.input name="social_instagram" label="Instagram URL" :value="$site['social_instagram']" /></div>
                    <div class="col-md-6"><x-admin.input name="social_youtube" label="YouTube URL" :value="$site['social_youtube']" /></div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-dark">Save Contact Page</button>
    </form>

@endsection
