@extends('layouts.app')

@section('content')
    <div class="row mb-4">
        <div class="col-md-8 offset-md-2">
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('sticky-notes.index') }}" class="btn btn-outline-secondary me-3">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h2 class="mb-0"><i class="fas fa-sticky-note me-2 text-primary"></i>{{ $stickyNote->title }}</h2>
                    <p class="text-muted mb-0">Dibuat: {{ $stickyNote->created_at->format('d M Y H:i') }}</p>
                </div>
            </div>

            <div class="card">
                <div class="card-body p-0">
                    <div class="sticky-note w-100" style="background-color: {{ $stickyNote->color }}; box-shadow: none; min-height: 300px;">
                        <div class="sticky-note-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">{{ $stickyNote->title }}</h5>
                            <div class="btn-group" role="group">
                                <a href="{{ route('sticky-notes.edit', $stickyNote) }}" class="btn btn-sm btn-link text-dark">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('sticky-notes.destroy', $stickyNote) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-link text-dark" onclick="return confirm('Yakin ingin menghapus catatan ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="sticky-note-content">
                            {{ $stickyNote->content }}
                        </div>
                        <div class="sticky-note-footer d-flex justify-content-between text-muted small">
                            <span><i class="fas fa-calendar me-1"></i> Dibuat: {{ $stickyNote->created_at->format('d M Y H:i') }}</span>
                            <span><i class="fas fa-clock me-1"></i> Diupdate: {{ $stickyNote->updated_at->format('d M Y H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                <a href="{{ route('sticky-notes.index') }}" class="btn btn-outline-secondary me-md-2">
                    <i class="fas fa-list me-1"></i> Kembali ke Daftar
                </a>
                <a href="{{ route('sticky-notes.edit', $stickyNote) }}" class="btn btn-primary">
                    <i class="fas fa-edit me-1"></i> Edit Catatan
                </a>
            </div>
        </div>
    </div>
@endsection