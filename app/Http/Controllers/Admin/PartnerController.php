<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesUploads;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PartnerRequest;
use App\Models\Partner;
use Illuminate\Http\RedirectResponse;

class PartnerController extends Controller
{
    use HandlesUploads;

    public function index()
    {
        $partners = Partner::orderBy('sort_order')->paginate(20);

        return view('admin.partners.index', compact('partners'));
    }

    public function create()
    {
        $partner = new Partner();

        return view('admin.partners.create', compact('partner'));
    }

    public function store(PartnerRequest $request): RedirectResponse
    {
        $data = $request->safe()->except('logo');
        $data['logo'] = $this->storeUploadedImage($request, 'logo', 'partners');

        Partner::create($data);

        return redirect()->route('admin.partners.index')->with('status', 'Partner added.');
    }

    public function edit(Partner $partner)
    {
        return view('admin.partners.edit', compact('partner'));
    }

    public function update(PartnerRequest $request, Partner $partner): RedirectResponse
    {
        $data = $request->safe()->except('logo');

        if ($logo = $this->storeUploadedImage($request, 'logo', 'partners')) {
            $this->deleteStoredImage($partner->logo);
            $data['logo'] = $logo;
        }

        $partner->update($data);

        return redirect()->route('admin.partners.index')->with('status', 'Partner updated.');
    }

    public function destroy(Partner $partner): RedirectResponse
    {
        $this->deleteStoredImage($partner->logo);
        $partner->delete();

        return redirect()->route('admin.partners.index')->with('status', 'Partner deleted.');
    }
}
