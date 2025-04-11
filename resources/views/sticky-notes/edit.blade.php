@extends('layouts.app')

@section('content')
    <div class="row mb-4">
        <div class="col-md-8 offset-md-2">
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('sticky-notes.index') }}" class="btn btn-outline-secondary me-3">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h2 class="mb-0"><i class="fas fa-edit me-2 text-primary"></i>Edit Catatan</h2>
                    <p class="text-muted mb-0">Perbarui catatan yang sudah ada</p>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('sticky-notes.update', $stickyNote) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="title" class="form-label fw-medium">Judul Catatan</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title', $stickyNote->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="content" class="form-label fw-medium">Isi Catatan</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" 
                                      id="content" name="content" rows="6" required>{{ old('content', $stickyNote->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-medium">Warna Catatan</label>
                            <input type="hidden" name="color" id="color" value="{{ $stickyNote->color }}">
                            
                            <div class="color-picker mt-2">
                                @foreach($colors as $value => $name)
                                    <div class="color-option {{ $value == $stickyNote->color ? 'selected' : '' }}" 
                                         style="background-color: {{ $value }}" 
                                         data-color="{{ $value }}" 
                                         title="{{ $name }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('sticky-notes.index') }}" class="btn btn-outline-secondary me-md-2">
                                <i class="fas fa-times me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Perbarui Catatan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection