<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Appointment;

use App\Models\Appointment;
use App\Models\Feedback;
use App\Orchid\Layouts\Appointment\AppointmentListLayout;
use App\Orchid\Layouts\Feedback\FeedbackListLayout;
use Illuminate\Http\Request;
use Orchid\Platform\Models\Role;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class AppointmentListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'appointments' => Appointment::with(['doctor','user'])
                ->filters()
                ->paginate(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return 'Записи на консультации';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'Здесь расположены записи на консультации';
    }

    public function permission(): ?iterable
    {
        return [
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
            AppointmentListLayout::class,
        ];
    }

    public function remove(Request $request)
    {
        $feedback = Feedback::findOrFail($request->input('id'));
        $feedback->delete();
        Toast::info('Запись обратной связи успешно удалена');
    }
}
