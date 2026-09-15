<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\PageContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PageContentController extends Controller
{
    public function editHome()
    {
        $content = PageContent::get('home');

        return view('admin.pages.home', compact('content'));
    }

    public function updateHome(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'hero_eyebrow' => ['required', 'string', 'max:255'],
            'hero_title_line1' => ['required', 'string', 'max:255'],
            'hero_title_highlight' => ['required', 'string', 'max:255'],
            'hero_title_line2' => ['required', 'string', 'max:255'],
            'hero_subtitle' => ['required', 'string', 'max:1000'],
            'hero_cta_primary' => ['required', 'string', 'max:100'],
            'hero_cta_secondary' => ['required', 'string', 'max:100'],
            'about_kicker' => ['required', 'string', 'max:255'],
            'about_title' => ['required', 'string', 'max:255'],
            'about_body' => ['required', 'string', 'max:1000'],
            'about_cta_text' => ['required', 'string', 'max:100'],
            'info_box_items' => ['required', 'string'],
            'events_kicker' => ['required', 'string', 'max:255'],
            'events_title' => ['required', 'string', 'max:255'],
            'awards_kicker' => ['required', 'string', 'max:255'],
            'awards_title' => ['required', 'string', 'max:255'],
            'speakers_kicker' => ['required', 'string', 'max:255'],
            'speakers_title' => ['required', 'string', 'max:255'],
            'gallery_kicker' => ['required', 'string', 'max:255'],
            'gallery_title' => ['required', 'string', 'max:255'],
            'registration_eyebrow' => ['required', 'string', 'max:255'],
            'registration_title_line1' => ['required', 'string', 'max:255'],
            'registration_title_highlight' => ['required', 'string', 'max:255'],
            'registration_subtitle' => ['required', 'string', 'max:1000'],
            'testimonials_eyebrow' => ['required', 'string', 'max:255'],
            'testimonials_title_line1' => ['required', 'string', 'max:255'],
            'testimonials_title_highlight' => ['required', 'string', 'max:255'],
            'testimonials_subtitle' => ['required', 'string', 'max:1000'],
            'partners_kicker' => ['required', 'string', 'max:255'],
        ]);

        $validated['info_box_items'] = array_values(array_filter(array_map('trim', explode("\n", $validated['info_box_items']))));

        PageContent::set('home', $validated);

        return back()->with('status', 'Home page content updated.');
    }

    public function editAbout()
    {
        $content = PageContent::get('about');

        return view('admin.pages.about', compact('content'));
    }

    public function updateAbout(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'hero_eyebrow' => ['required', 'string', 'max:255'],
            'hero_title_line1' => ['required', 'string', 'max:255'],
            'hero_title_line2' => ['required', 'string', 'max:255'],
            'hero_subtitle' => ['required', 'string', 'max:1000'],
            'intro_kicker' => ['required', 'string', 'max:255'],
            'intro_title' => ['required', 'string', 'max:255'],
            'intro_body_1' => ['required', 'string', 'max:1000'],
            'intro_body_2' => ['required', 'string', 'max:1000'],
            'stat_1_value' => ['required', 'string', 'max:50'],
            'stat_1_label' => ['required', 'string', 'max:100'],
            'stat_2_value' => ['required', 'string', 'max:50'],
            'stat_2_label' => ['required', 'string', 'max:100'],
            'values_kicker' => ['required', 'string', 'max:255'],
            'values_title' => ['required', 'string', 'max:255'],
            'value_icon' => ['required', 'array', 'min:1'],
            'value_label' => ['required', 'array', 'min:1'],
            'value_description' => ['required', 'array', 'min:1'],
            'cta_title' => ['required', 'string', 'max:255'],
            'cta_text' => ['required', 'string', 'max:255'],
            'cta_button_text' => ['required', 'string', 'max:100'],
        ]);

        $values = [];
        foreach ($validated['value_label'] as $index => $label) {
            if (blank($label)) {
                continue;
            }

            $values[] = [
                'icon' => $validated['value_icon'][$index] ?? 'bi-star',
                'label' => $label,
                'description' => $validated['value_description'][$index] ?? '',
            ];
        }
        $validated['values'] = $values;
        unset($validated['value_icon'], $validated['value_label'], $validated['value_description']);

        PageContent::set('about', $validated);

        return back()->with('status', 'About page content updated.');
    }

    public function editContact()
    {
        $content = PageContent::get('contact');
        $site = PageContent::get('site');

        return view('admin.pages.contact', compact('content', 'site'));
    }

    public function updateContact(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'hero_eyebrow' => ['required', 'string', 'max:255'],
            'hero_title_line1' => ['required', 'string', 'max:255'],
            'hero_title_line2' => ['required', 'string', 'max:255'],
            'hero_subtitle' => ['required', 'string', 'max:1000'],
            'intro_kicker' => ['required', 'string', 'max:255'],
            'intro_title' => ['required', 'string', 'max:255'],
            'contact_address' => ['required', 'string', 'max:500'],
            'contact_phone' => ['required', 'string', 'max:50'],
            'contact_email' => ['required', 'email', 'max:255'],
            'footer_copy' => ['required', 'string', 'max:500'],
            'social_facebook' => ['nullable', 'string', 'max:255'],
            'social_twitter' => ['nullable', 'string', 'max:255'],
            'social_linkedin' => ['nullable', 'string', 'max:255'],
            'social_instagram' => ['nullable', 'string', 'max:255'],
            'social_youtube' => ['nullable', 'string', 'max:255'],
        ]);

        $siteKeys = array_keys(PageContent::defaults()['site']);

        PageContent::set('site', collect($validated)->only($siteKeys)->toArray());
        PageContent::set('contact', collect($validated)->except($siteKeys)->toArray());

        return back()->with('status', 'Contact page content updated.');
    }
}
