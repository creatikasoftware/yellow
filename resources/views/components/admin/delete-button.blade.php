@props(['action', 'confirm' => 'Are you sure you want to delete this?'])
<form method="POST" action="{{ $action }}" onsubmit="return confirm('{{ $confirm }}');" class="d-inline">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
</form>
