@extends('layouts.app')

@section('content')
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h2 class="mb-0"><i class="fas fa-sticky-note me-2 text-primary"></i>Daftar Catatan</h2>
            <p class="text-muted mb-0">Kelola catatan Anda dengan mudah</p>
        </div>
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <a href="{{ route('sticky-notes.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Tambah Catatan Baru
            </a>
        </div>
    </div>

    <div class="filter-section">
        <form action="{{ route('sticky-notes.index') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <label class="form-label fw-medium">Urutkan</label>
                <select name="sort" class="form-select" onchange="this.form.submit()">
                    <option value="created_at-desc" {{ request('sort') == 'created_at-desc' ? 'selected' : '' }}>Terbaru</option>
                    <option value="created_at-asc" {{ request('sort') == 'created_at-asc' ? 'selected' : '' }}>Terlama</option>
                    <option value="title-asc" {{ request('sort') == 'title-asc' ? 'selected' : '' }}>Judul (A-Z)</option>
                    <option value="title-desc" {{ request('sort') == 'title-desc' ? 'selected' : '' }}>Judul (Z-A)</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-medium">Warna</label>
                <select name="color" class="form-select" onchange="this.form.submit()">
                    <option value="all" {{ request('color') == 'all' ? 'selected' : '' }}>Semua</option>
                    @foreach(\App\Models\StickyNote::availableColors() as $value => $name)
                        <option value="{{ $value }}" {{ request('color') == $value ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="reset" class="btn btn-outline-secondary w-100" onclick="window.location='{{ route('sticky-notes.index') }}'">
                    <i class="fas fa-redo me-1"></i> Reset
                </button>
            </div>
        </form>
    </div>

    <div class="task-counter mb-3">
        <span class="me-3"><i class="fas fa-sticky-note me-1"></i> Total: {{ $notes->count() }}</span>
    </div>

    <div class="card">
        <div class="card-body p-0">
            @if($notes->count() > 0)
                <div class="row p-3">
                    @foreach($notes as $note)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="sticky-note" style="background-color: {{ $note->color }}">
                                <div class="sticky-note-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0 text-truncate" style="max-width: 70%;" title="{{ $note->title }}">
                                        {{ $note->title }}
                                    </h5>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('sticky-notes.show', $note) }}" class="btn btn-sm btn-link text-dark">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('sticky-notes.edit', $note) }}" class="btn btn-sm btn-link text-dark">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('sticky-notes.destroy', $note) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-link text-dark" onclick="return confirm('Yakin ingin menghapus catatan ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <div class="sticky-note-content" style="max-height: 120px; overflow: hidden; text-overflow: ellipsis;">
                                    {{ Str::limit($note->content, 150) }}
                                </div>
                                <div class="sticky-note-footer text-muted small d-flex justify-content-between">
                                    <span><i class="fas fa-calendar me-1"></i> {{ $note->created_at->format('d M Y') }}</span>
                                    <a href="{{ route('sticky-notes.show', $note) }}" class="text-decoration-none text-dark">
                                        Lihat <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-5 text-center">
                    <img src="https://cdnjs.cloudflare.com/ajax/libs/twemoji/14.0.2/svg/1f4dd.svg" alt="Empty Notes" style="width: 80px; height: 80px;">
                    <h4 class="mt-3">Belum ada catatan</h4>
                    <p class="text-muted">Tambahkan catatan baru untuk memulai</p>
                    <a href="{{ route('sticky-notes.create') }}" class="btn btn-primary mt-2">
                        <i class="fas fa-plus me-1"></i> Tambah Catatan
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection