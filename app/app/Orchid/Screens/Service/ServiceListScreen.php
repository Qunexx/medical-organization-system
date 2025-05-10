<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Service;

use App\Models\Feedback;
use App\Models\Service;
use App\Orchid\Layouts\Feedback\FeedbackListLayout;
use App\Orchid\Layouts\Service\ServiceListLayout;
use Illuminate\Http\Request;
use Orchid\Platform\Models\Role;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class ServiceListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'services' => Service::query()->paginate(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return 'Услуги';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'Здесь находится список услуг, оказываемых в клинике';
    }

    public function permission(): ?iterable
    {
        return [];
    }

    /**
     * The screen's action buttons.
     *
     * @return Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make(__('Add'))
                ->icon('bs.plus-circle')
                ->route('platform.service.create'),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return string[]|\Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [
            ServiceListLayout::class,
        ];
    }

    public function remove(Request $request)
    {
        $service = Service::findOrFail($request->input('id'));
        $service->delete();
        Toast::info('Услуга успешно удалена');
    }
}
