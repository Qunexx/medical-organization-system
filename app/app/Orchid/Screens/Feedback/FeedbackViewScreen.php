<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Feedback;

use App\Models\Feedback;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Orchid\Platform\Models\Role;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\Sight;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class FeedbackViewScreen extends Screen
{
    public $feedback;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Feedback $feedback): iterable
    {
        $this->feedback = Feedback::findOrFail($feedback->id);
        return [
            'feedback' => $this->feedback,
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
        return 'Детали обратной связи';
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
            Button::make(!empty($this->feedback->processed_at) ? 'Снять с обработки' : 'Обработать')
                ->icon($this->feedback->is_processed ? 'bs.check-circle' : 'bs.arrow-repeat')
                ->method('process')
                ->confirm('Вы уверены что хотите изменить статус обработки?')
                ->canSee($this->feedback->exists)
                ->parameters([
                    'id' => $this->feedback->id,
                ]),
            Button::make('Удалить')
                ->icon('bs.trash3')
                ->confirm('После удаления обратную связь нельзя будет восстановить')
                ->method('remove', [
                    'id' => $this->feedback->id,
                ]),
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
            Layout::legend('feedback', [
                Sight::make('id','Id'),
                Sight::make('fio','ФИО'),
                Sight::make('subject','Тема'),
                Sight::make('message','Сообщение'),
                Sight::make('created_at','Отправлено'),
                Sight::make('updated_at','Дата изменения'),
                Sight::make('processed_at','Обработано'),
            ])->title('Детали обратной связи'),
        ];
    }

    public function remove(Request $request)
    {
        $feedback = Feedback::findOrFail($request->input('id'));
        $feedback->delete();
        Toast::info('Запись обратной связи успешно удалена');
        return redirect()->route('platform.feedback');
    }

    public function process(Request $request)
    {
        $id = $request->input('id');
        $feedback = Feedback::findOrFail($id);
        $feedback->processed_at = $feedback->processed_at ? null : now();
        $feedback->save();

        Toast::info(
            $feedback->processed_at
                ? 'Запись помечена как обработанная'
                : 'Запись снята с обработки'
        );

        return back();
    }
}
