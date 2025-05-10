<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Feedback;

use App\Models\Feedback;
use App\Orchid\Layouts\Feedback\FeedbackListLayout;
use Illuminate\Http\Request;
use Orchid\Platform\Models\Role;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class FeedbackListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'feedbacks' => Feedback::query()->paginate(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return 'Обратная связь';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'Здесь расположены записи из формы обратной связи на главной странице';
    }

    public function permission(): ?iterable
    {
        return [
            'platform.systems.roles',
        ];
    }

    /**
     * The screen's action buttons.
     *
     * @return Action[]
     */
    public function commandBar(): iterable
    {
        return [
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
            FeedbackListLayout::class,
        ];
    }

    public function remove(Request $request)
    {
        $feedback = Feedback::findOrFail($request->input('id'));
        $feedback->delete();
        Toast::info('Запись обратной связи успешно удалена');
    }
}
