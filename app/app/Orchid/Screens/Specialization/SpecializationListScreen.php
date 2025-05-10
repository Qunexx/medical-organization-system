<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Specialization;

use App\Models\Feedback;
use App\Models\Service;
use App\Models\Specialization;
use App\Orchid\Layouts\Feedback\FeedbackListLayout;
use App\Orchid\Layouts\Specialization\SpecializationListLayout;
use Illuminate\Http\Request;
use Orchid\Platform\Models\Role;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class SpecializationListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'specializations' => Specialization::query()->paginate(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return 'Специализации';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'Здесь находится список специализаций, которые доступны для привязки к врачам';
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
                ->route('platform.specialization.create'),
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
            SpecializationListLayout::class,
        ];
    }

    public function remove(Request $request)
    {
        $specialization = Specialization::findOrFail($request->input('id'));
        $specialization->delete();
        Toast::info('Услуга успешно удалена');
    }
}
