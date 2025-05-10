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

    <main class="dashboard-content max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <section class="quick-actions mb-12">
            <h2 class="sr-only">Быстрые действия</h2>

{{--            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">--}}
{{--                <article class="action-card group">--}}
{{--                    <a href="{{ route('platform.systems.users') }}"--}}
{{--                       class="block h-full p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-200 border border-gray-200 hover:border-indigo-200">--}}
{{--                        <div class="flex items-start">--}}
{{--                            <div class="action-icon mr-4 shrink-0">--}}
{{--                                <x-orchid-icon path="people"--}}
{{--                                               class="h-10 w-10 text-indigo-600 bg-indigo-50 p-2 rounded-lg"/>--}}
{{--                            </div>--}}
{{--                            <div class="action-content">--}}
{{--                                <h3 class="text-lg font-semibold text-gray-900 mb-1">--}}
{{--                                    Пользователи--}}
{{--                                </h3>--}}
{{--                                <p class="text-sm text-gray-500 leading-relaxed">--}}
{{--                                    Управление учетными записями, правами доступа и ролями пользователей--}}
{{--                                </p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </a>--}}
{{--                </article>--}}
{{--            </div>--}}
        </section>
    </main>
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
