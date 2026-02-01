<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - {{ config('app.name', 'Cipta Imaji') }}</title>
    
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @stack('styles')
</head>
<body class="bg-gray-100">
    <!-- Sidebar -->
    @include('pages.admin.layouts.sidebar')
    
    <div class="ml-64"> <!-- Sesuaikan dengan width sidebar -->
        <!-- Header -->
        @include('pages.admin.layouts.header')
        
        <!-- Main Content -->
        <main class="p-6">
            <!-- Page Header -->
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800">
                    @hasSection('page-title')
                        @yield('page-title')
                    @else
                        @yield('title', 'Dashboard')
                    @endif
                </h1>
                
                @hasSection('page-description')
                <p class="text-gray-600 mt-1">
                    @yield('page-description')
                </p>
                @endif
            </div>
            
            <!-- Alerts -->
            @if(session('success'))
                @include('pages.admin.components.alert', ['type' => 'success', 'message' => session('success')])
            @endif
            
            @if(session('error'))
                @include('pages.admin.components.alert', ['type' => 'error', 'message' => session('error')])
            @endif
            
            <!-- Page Content -->
            @yield('content')
        </main>
        
        <!-- Footer -->
        @include('pages.admin.layouts.footer')
    </div>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @stack('scripts')
    
    @include('pages.admin.layouts.scripts')
</body>
</html>