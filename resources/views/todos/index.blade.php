@extends('layouts.app')

@section('content')
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h2 class="mb-0"><i class="fas fa-list-check me-2 text-primary"></i>Daftar Tugas</h2>
            <p class="text-muted mb-0">Kelola tugas Anda dengan mudah</p>
        </div>
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <a href="{{ route('todos.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Tambah Tugas Baru
            </a>
        </div>
    </div>

    <div class="filter-section">
        <form action="{{ route('todos.index') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <label class="form-label fw-medium">Status</label>
                <select name="filter" class="form-select" onchange="this.form.submit()">
                    <option value="all" {{ request('filter') == 'all' ? 'selected' : '' }}>Semua</option>
                    <option value="active" {{ request('filter') == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="completed" {{ request('filter') == 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="overdue" {{ request('filter') == 'overdue' ? 'selected' : '' }}>Terlambat</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-medium">Prioritas</label>
                <select name="priority" class="form-select" onchange="this.form.submit()">
                    <option value="all" {{ request('priority') == 'all' ? 'selected' : '' }}>Semua</option>
                    <option value="tinggi" {{ request('priority') == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                    <option value="sedang" {{ request('priority') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                    <option value="rendah" {{ request('priority') == 'rendah' ? 'selected' : '' }}>Rendah</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-medium">Urutkan</label>
                <select name="sort" class="form-select" onchange="this.form.submit()">
                    <option value="created_at-desc" {{ request('sort') == 'created_at-desc' ? 'selected' : '' }}>Terbaru
                    </option>
                    <option value="created_at-asc" {{ request('sort') == 'created_at-asc' ? 'selected' : '' }}>Terlama
                    </option>
                    <option value="due_date-asc" {{ request('sort') == 'due_date-asc' ? 'selected' : '' }}>Tenggat Terdekat
                    </option>
                    <option value="priority-desc" {{ request('sort') == 'priority-desc' ? 'selected' : '' }}>Prioritas
                        Tertinggi</option>
                </select>
            </div>
        </form>
    </div>

    <div class="task-counter mb-3">
        <span class="me-3"><i class="fas fa-tasks me-1"></i> Total: {{ $todos->count() }}</span>
        <span class="me-3"><i class="fas fa-spinner me-1"></i> Aktif:
            {{ $todos->where('completed', false)->count() }}</span>
        <span class="me-3"><i class="fas fa-check-double me-1"></i> Selesai:
            {{ $todos->where('completed', true)->count() }}</span>
        <span><i class="fas fa-exclamation-circle me-1 text-danger"></i> Terlambat:
            {{ $todos->where('is_overdue', true)->count() }}</span>
    </div>

    <div class="card">
        <div class="card-body p-0">
            @if($todos->count() > 0)
                <div class="list-group list-group-flush">
                    @foreach($todos as $todo)
                        <div
                            class="list-group-item p-3 todo-item position-relative {{ $todo->completed ? 'completed-todo bg-light' : '' }}">
                            <div class="priority-indicator bg-{{ $todo->priority_badge }}"></div>
                            <div class="d-flex justify-content-between">
                                <div class="d-flex align-items-start" style="width: 80%;">
                                    <div class="me-3">
                                        @if($todo->can_be_completed)
                                            <form action="{{ route('todos.toggle', $todo) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="btn btn-sm btn-{{ $todo->completed ? 'success' : 'outline-secondary' }} rounded-circle">
                                                    <i class="fas {{ $todo->completed ? 'fa-check' : 'fa-circle' }}"></i>
                                                </button>
                                            </form>
                                        @else
                                            <button type="button" class="btn btn-sm btn-danger rounded-circle" disabled
                                                title="Tugas terlambat tidak dapat diselesaikan">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="d-flex align-items-center mb-1">
                                            <span class="fw-medium {{ $todo->completed ? 'text-decoration-line-through' : '' }}">
                                                {{ $todo->title }}
                                            </span>
                                            <span class="badge bg-{{ $todo->priority_badge }} ms-2">
                                                {{ ucfirst($todo->priority) }}
                                            </span>
                                            @if($todo->is_overdue)
                                                <span class="badge bg-danger ms-2">
                                                    Terlambat
                                                </span>
                                            @endif
                                        </div>
                                        @if($todo->description)
                                            <p class="text-muted small mb-2">{{ $todo->description }}</p>
                                        @endif
                                        <div class="date-info text-muted">
                                            @if($todo->start_date)
                                                <span class="me-3" data-bs-toggle="tooltip" title="Tanggal Mulai">
                                                    <i class="fas fa-calendar me-1"></i> Mulai: {{ $todo->start_date->format('d M Y') }}
                                                </span>
                                            @endif
                                            @if($todo->due_date)
                                                <span class="{{ $todo->is_overdue ? 'overdue' : '' }}" data-bs-toggle="tooltip"
                                                    title="Tenggat Waktu">
                                                    <i class="fas fa-calendar-check me-1"></i> Deadline:
                                                    {{ $todo->due_date->format('d M Y') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="btn-group" role="group">
                                        @if(!$todo->completed && !$todo->is_overdue)
                                            <a href="{{ route('todos.edit', $todo) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @else
                                            <button type="button" class="btn btn-sm btn-outline-secondary" disabled
                                                title="Tugas yang sudah selesai atau terlambat tidak dapat diedit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        @endif
                                        <form action="{{ route('todos.destroy', $todo) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Yakin ingin menghapus tugas ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-5 text-center">
                    <img src="https://cdnjs.cloudflare.com/ajax/libs/twemoji/14.0.2/svg/1f4c3.svg" alt="Empty List"
                        style="width: 80px; height: 80px;">
                    <h4 class="mt-3">Belum ada tugas</h4>
                    <p class="text-muted">Tambahkan tugas baru untuk memulai</p>
                    <a href="{{ route('todos.create') }}" class="btn btn-primary mt-2">
                        <i class="fas fa-plus me-1"></i> Tambah Tugas
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection