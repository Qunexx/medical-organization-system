<div class="admin-dashboard">
    <header class="dashboard-header mb-12 text-center">
        <div class="max-w-2xl mx-auto">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                Добро пожаловать, {{ Auth::user()->first_name }}!
            </h1>
            <p class="text-lg text-gray-600">
                Панель управления {{ config('app.name') }}
            </p>
        </div>
    </header>
</div>

<style>
    .dashboard-header {
        padding: 4rem 1rem;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-bottom: 1px solid #e2e8f0;
    }

    .action-card {
        position: relative;
        transition: transform 0.2s;
    }

    .action-card:hover {
        transform: translateY(-2px);
    }

    .action-icon {
        transition: transform 0.2s;
    }

    .action-card:hover .action-icon {
        transform: scale(1.05);
    }
</style>
