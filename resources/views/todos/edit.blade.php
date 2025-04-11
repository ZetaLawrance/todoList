@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('todos.index') }}" class="btn btn-outline-secondary btn-sm me-3">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h2 class="mb-0">Edit Tugas</h2>
            </div>
            
            <div class="card">
                <div class="card-body p-4">
                    <form action="{{ route('todos.update', $todo) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="title" class="form-label fw-medium">Judul Tugas <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $todo->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label fw-medium">Deskripsi (Opsional)</label>
                            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $todo->description) }}</textarea>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="priority" class="form-label fw-medium">Prioritas <span class="text-danger">*</span></label>
                                <select class="form-select @error('priority') is-invalid @enderror" id="priority" name="priority" required>
                                    <option value="rendah" {{ old('priority', $todo->priority) == 'rendah' ? 'selected' : '' }}>Rendah</option>
                                    <option value="sedang" {{ old('priority', $todo->priority) == 'sedang' ? 'selected' : '' }}>Sedang</option>
                                    <option value="tinggi" {{ old('priority', $todo->priority) == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                                </select>
                                @error('priority')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="start_date" class="form-label fw-medium">Tanggal Mulai</label>
                                <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date', $todo->start_date ? $todo->start_date->format('Y-m-d') : '') }}">
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="due_date" class="form-label fw-medium">Tenggat Waktu</label>
                                <input type="date" class="form-control @error('due_date') is-invalid @enderror" id="due_date" name="due_date" value="{{ old('due_date', $todo->due_date ? $todo->due_date->format('Y-m-d') : '') }}">
                                @error('due_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" name="completed" id="completed" {{ $todo->completed ? 'checked' : '' }}>
                            <label class="form-check-label" for="completed">
                                Tandai sebagai selesai
                            </label>
                        </div>
                        
                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('todos.index') }}" class="btn btn-light me-2">Batal</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection