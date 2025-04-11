<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->filter ?? 'all';
        $sort = $request->sort ?? 'created_at-desc';

        [$sortField, $sortDirection] = explode('-', $sort);

        $query = Todo::query();

        if ($filter === 'active') {
            $query->where('completed', false);
        } elseif ($filter === 'completed') {
            $query->where('completed', true);
        } elseif ($filter === 'overdue') {
            $query->whereDate('due_date', '<', now())
                ->where('completed', false);
        }

        // Filter berdasarkan prioritas
        if ($request->has('priority') && $request->priority != 'all') {
            $query->where('priority', $request->priority);
        }

        // Sort
        $query->orderBy($sortField, $sortDirection);

        $todos = $query->get();

        return view('todos.index', compact('todos', 'filter', 'sort'));
    }

    public function create()
    {
        return view('todos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255|unique:todos,title',
            'priority' => 'required|in:rendah,sedang,tinggi',
            'start_date' => 'nullable|date|after_or_equal:today',
            'due_date' => 'nullable|date|after_or_equal:start_date',
        ], [
            'title.unique' => 'Judul tugas sudah digunakan, silakan pilih judul lain.',
            'start_date.after_or_equal' => 'Tanggal mulai tidak boleh di masa lalu.',
            'due_date.after_or_equal' => 'Tenggat waktu harus setelah atau sama dengan tanggal mulai.'
        ]);

        Todo::create([
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'start_date' => $request->start_date,
            'due_date' => $request->due_date,
        ]);

        return redirect()->route('todos.index')->with('success', 'Todo berhasil dibuat!');
    }

    public function edit(Todo $todo)
    {
        // Cek jika todo sudah selesai atau terlambat
        if ($todo->completed || $todo->is_overdue) {
            return redirect()->route('todos.index')->with('error', 'Tugas yang sudah selesai atau terlambat tidak dapat diedit!');
        }

        return view('todos.edit', compact('todo'));
    }

    public function update(Request $request, Todo $todo)
    {
        // Cek lagi jika todo sudah selesai atau terlambat
        if ($todo->completed || $todo->is_overdue) {
            return redirect()->route('todos.index')->with('error', 'Tugas yang sudah selesai atau terlambat tidak dapat diedit!');
        }
        
        $request->validate([
            'title' => 'required|max:255|unique:todos,title,' . $todo->id,
            'priority' => 'required|in:rendah,sedang,tinggi',
            'start_date' => 'nullable|date|after_or_equal:today',
            'due_date' => 'nullable|date|after_or_equal:start_date',
        ], [
            'title.unique' => 'Judul tugas sudah digunakan, silakan pilih judul lain.',
            'start_date.after_or_equal' => 'Tanggal mulai tidak boleh di masa lalu.',
            'due_date.after_or_equal' => 'Tenggat waktu harus setelah atau sama dengan tanggal mulai.'
        ]);
    
        $todo->update([
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'start_date' => $request->start_date,
            'due_date' => $request->due_date,
            'completed' => $request->has('completed'), // Mengubah status selesai berdasarkan checkbox
        ]);
    
        return redirect()->route('todos.index')->with('success', 'Todo berhasil diupdate!');
    }
    
    public function destroy(Todo $todo)
    {
        $todo->delete();
        return redirect()->route('todos.index')->with('success', 'Todo berhasil dihapus!');
    }

    public function toggleComplete(Todo $todo)
    {
        if ($todo->is_overdue && !$todo->completed) {
            return redirect()->route('todos.index')->with('error', 'Tugas yang sudah terlambat tidak dapat ditandai selesai!');
        }

        $todo->update([
            'completed' => !$todo->completed
        ]);

        return redirect()->route('todos.index');
    }
}