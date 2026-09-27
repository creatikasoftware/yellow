@props(['name', 'label', 'value' => null, 'help' => null])

<div class="mb-3">
    <label class="form-label">{{ $label }}</label>
    <div id="{{ $name }}_editor" style="background:#fff">{!! old($name, $value) !!}</div>
    <textarea name="{{ $name }}" id="{{ $name }}" class="d-none">{{ old($name, $value) }}</textarea>
    @if($help)<div class="form-text">{{ $help }}</div>@endif
    @error($name)<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
</div>

@once
    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
        <style>.ql-editor{min-height:300px}</style>
    @endpush
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
        <script>
            function initRichEditor(name) {
                const hidden = document.getElementById(name);
                const quill = new Quill('#' + name + '_editor', {
                    theme: 'snow',
                    modules: {
                        toolbar: {
                            container: [
                                [{ header: [1, 2, 3, false] }],
                                ['bold', 'italic', 'underline', 'strike'],
                                [{ list: 'ordered' }, { list: 'bullet' }],
                                ['link', 'image', 'video'],
                                ['clean'],
                            ],
                            handlers: { image: () => uploadRichEditorImage(quill) },
                        },
                    },
                });
                quill.on('text-change', () => { hidden.value = quill.root.innerHTML; });
            }

            function uploadRichEditorImage(quill) {
                const input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');
                input.click();
                input.onchange = () => {
                    const file = input.files[0];
                    if (!file) return;
                    const formData = new FormData();
                    formData.append('image', file);
                    fetch('{{ route('admin.uploads.image') }}', {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                        body: formData,
                    })
                        .then((r) => r.json())
                        .then((data) => {
                            const range = quill.getSelection(true);
                            quill.insertEmbed(range.index, 'image', data.url);
                        });
                };
            }
        </script>
    @endpush
@endonce

@push('scripts')
    <script>initRichEditor('{{ $name }}');</script>
@endpush
