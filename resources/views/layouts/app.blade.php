<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZTask - Aplikasi Todo List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
        }
        
        .sidebar {
            width: 280px;
            background: linear-gradient(160deg, #6366F1 0%, #8B5CF6 100%);
            color: white;
            min-height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            z-index: 1000;
            transition: all 0.3s ease;
        }
        
        .sidebar-header {
            padding: 1.5rem;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .sidebar-logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .sidebar-logo i {
            margin-right: 10px;
            font-size: 1.3em;
        }
        
        .sidebar-menu {
            padding: 1rem 0;
        }
        
        .sidebar-menu-item {
            padding: 0.8rem 1.5rem;
            display: flex;
            align-items: center;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .sidebar-menu-item.active, .sidebar-menu-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            border-left: 4px solid white;
        }
        
        .sidebar-menu-item i {
            margin-right: 10px;
            width: 24px;
            text-align: center;
        }
        
        .content-wrapper {
            flex: 1;
            margin-left: 280px;
            padding: 2rem;
            transition: all 0.3s ease;
            width: calc(100% - 280px);
        }
        
        @media (max-width: 768px) {
            .sidebar {
                width: 70px;
                transform: translateX(0);
            }
            
            .sidebar.show {
                width: 280px;
            }
            
            .sidebar-header {
                padding: 1rem 0.5rem;
            }
            
            .sidebar-logo span, .sidebar-menu-item span, .sidebar-footer span {
                display: none;
            }
            
            .sidebar.show .sidebar-logo span, 
            .sidebar.show .sidebar-menu-item span, 
            .sidebar.show .sidebar-footer span {
                display: inline;
            }
            
            .content-wrapper {
                margin-left: 70px;
                width: calc(100% - 70px);
            }
            
            .sidebar.show + .content-wrapper {
                margin-left: 280px;
            }
        }
        
        .toggle-sidebar {
            display: none;
        }
        
        @media (max-width: 768px) {
            .toggle-sidebar {
                display: block;
                position: fixed;
                left: 15px;
                top: 15px;
                z-index: 1010;
                background-color: #6366F1;
                color: white;
                border: none;
                border-radius: 50%;
                width: 40px;
                height: 40px;
                text-align: center;
                box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            }
        }
        
        .card {
            border-radius: 10px;
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        
        .card-header {
            background-color: #fff;
            border-bottom: 1px solid #f0f0f0;
            padding: 1rem 1.5rem;
            font-weight: 600;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #6366F1 0%, #8B5CF6 100%);
            border: none;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
        }
        
        .badge {
            padding: 0.4em 0.6em;
            font-weight: 500;
        }
        
        .todo-item {
            transition: all 0.2s ease;
        }
        
        .todo-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
        
        .completed-todo {
            opacity: 0.7;
        }
        
        .priority-indicator {
            width: 4px;
            height: 100%;
            position: absolute;
            left: 0;
            top: 0;
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
        }
        
        .date-info {
            font-size: 0.8rem;
        }
        
        .filter-section {
            background-color: white;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        
        .task-counter {
            font-size: 0.85rem;
            color: #6c757d;
        }
        
        .overdue {
            color: #dc3545;
            font-weight: 500;
        }
        
        .sticky-note {
            border-radius: 5px;
            min-height: 200px;
            margin-bottom: 1.5rem;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            overflow: hidden;
        }
        
        .sticky-note:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.15);
        }
        
        .sticky-note-header {
            padding: 15px;
            border-bottom: 1px solid rgba(0,0,0,0.1);
        }
        
        .sticky-note-content {
            padding: 15px;
            white-space: pre-line;
        }
        
        .sticky-note-footer {
            padding: 10px 15px;
            border-top: 1px solid rgba(0,0,0,0.1);
            background-color: rgba(0,0,0,0.02);
        }
        
        .color-picker {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        
        .color-option {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            cursor: pointer;
            border: 3px solid transparent;
        }
        
        .color-option.selected {
            border-color: rgba(0,0,0,0.3);
        }
    </style>
</head>
<body>
    <button class="toggle-sidebar" id="toggleSidebar">
        <i class="fas fa-bars"></i>
    </button>

    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="/" class="sidebar-logo">
                <i class="fas fa-check-circle"></i>
                <span>ZTask</span>
            </a>
        </div>
        
        <div class="sidebar-menu">
            <a href="{{ route('todos.index') }}" class="sidebar-menu-item {{ request()->routeIs('todos.*') ? 'active' : '' }}">
                <i class="fas fa-tasks"></i>
                <span>Daftar Tugas</span>
            </a>
            <a href="{{ route('sticky-notes.index') }}" class="sidebar-menu-item {{ request()->routeIs('sticky-notes.*') ? 'active' : '' }}">
                <i class="fas fa-sticky-note"></i>
                <span>Catatan</span>
            </a>
        </div>
    </div>

    <div class="content-wrapper">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Untuk menampilkan tooltip
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
        
        // Toggle sidebar
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('show');
        });
        
        // Color picker for sticky notes
        document.querySelectorAll('.color-option').forEach(option => {
            option.addEventListener('click', function() {
                document.querySelectorAll('.color-option').forEach(el => el.classList.remove('selected'));
                this.classList.add('selected');
                document.getElementById('color').value = this.dataset.color;
            });
        });
    </script>
</body>
</html>