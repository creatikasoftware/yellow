@csrf

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-body">
                <x-admin.input name="title" label="Title" :value="$event->title" required />
                <x-admin.input name="slug" label="Slug" :value="$event->slug" help="Leave blank to auto-generate from the title." />
                <x-admin.input name="summary" label="Summary" :value="$event->summary" help="Short teaser shown on event cards." />
                <x-admin.textarea name="description" label="Description" :value="$event->description" rows="4" />
                <x-admin.textarea name="highlights" label="Highlights" :value="$event->highlights ? implode(PHP_EOL, $event->highlights) : null" rows="4" help="One highlight per line." />
                <x-admin.file name="image" label="Event Image" :current="$event->image" />
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Agenda</span>
                <button type="button" class="btn btn-sm btn-outline-dark" id="addAgendaRow"><i class="bi bi-plus-lg"></i> Add Item</button>
            </div>
            <div class="card-body" id="agendaRows">
                @forelse($event->agendaItems ?? [] as $item)
                    <div class="row g-2 mb-2 agenda-row">
                        <div class="col-3"><input type="text" name="agenda_time[]" value="{{ $item->time }}" class="form-control form-control-sm" placeholder="05:00 PM"></div>
                        <div class="col-4"><input type="text" name="agenda_title[]" value="{{ $item->title }}" class="form-control form-control-sm" placeholder="Session title"></div>
                        <div class="col-4"><input type="text" name="agenda_description[]" value="{{ $item->description }}" class="form-control form-control-sm" placeholder="Description (optional)"></div>
                        <div class="col-1"><button type="button" class="btn btn-sm btn-outline-danger remove-agenda-row"><i class="bi bi-x"></i></button></div>
                    </div>
                @empty
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-body">
                <x-admin.input name="starts_at" label="Date" type="date" :value="optional($event->starts_at)->format('Y-m-d')" required />
                <x-admin.input name="start_time" label="Start Time" :value="$event->start_time" help="e.g. 09:00 AM" />
                <x-admin.input name="end_time" label="End Time" :value="$event->end_time" help="e.g. 06:00 PM IST" />
                <x-admin.input name="location" label="Location" :value="$event->location" />
                <x-admin.input name="format" label="Format" :value="$event->format" help="e.g. Conference & Awards" />
                <x-admin.input name="expected_attendees" label="Expected Attendees" :value="$event->expected_attendees" help="e.g. 500+ Expected Attendees" />
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <x-admin.select name="status" label="Status" :value="$event->status" :options="['draft' => 'Draft', 'published' => 'Published']" required />
                <x-admin.checkbox name="registration_open" label="Registrations open" :checked="$event->registration_open ?? true" />
                <x-admin.checkbox name="is_featured" label="Feature on homepage" :checked="$event->is_featured ?? false" />
                <button type="submit" class="btn btn-dark w-100 mt-2">Save Event</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('addAgendaRow').addEventListener('click', function () {
        const wrap = document.getElementById('agendaRows');
        const row = document.createElement('div');
        row.className = 'row g-2 mb-2 agenda-row';
        row.innerHTML = `
            <div class="col-3"><input type="text" name="agenda_time[]" class="form-control form-control-sm" placeholder="05:00 PM"></div>
            <div class="col-4"><input type="text" name="agenda_title[]" class="form-control form-control-sm" placeholder="Session title"></div>
            <div class="col-4"><input type="text" name="agenda_description[]" class="form-control form-control-sm" placeholder="Description (optional)"></div>
            <div class="col-1"><button type="button" class="btn btn-sm btn-outline-danger remove-agenda-row"><i class="bi bi-x"></i></button></div>
        `;
        wrap.appendChild(row);
    });

    document.getElementById('agendaRows').addEventListener('click', function (e) {
        if (e.target.closest('.remove-agenda-row')) {
            e.target.closest('.agenda-row').remove();
        }
    });
</script>
@endpush
