<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Specialization;

use App\Models\Service;
use App\Models\Specialization;
use App\Orchid\Layouts\Specialization\SpecializationEditLayout;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class SpecializationEditScreen extends Screen
{

    public $specialization;
    private $entity;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Specialization $specialization): iterable
    {
        return [
            'specialization' => $specialization,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return !$this->specialization->exists ? 'Создание специализации' : 'Редактирование специализации';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return '';
    }

    /**
     * The permissions required to access this screen.
     */
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
            Button::make(__('Save'))
                ->icon('bs.check-circle')
                ->method('save'),

            Button::make(__('Remove'))
                ->icon('bs.trash3')
                ->method('remove')
                ->confirm('После удаления специализацию придётся создавать по новой')
                ->canSee($this->specialization->exists),
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
          SpecializationEditLayout::class,
        ];
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Request $request, Specialization $specialization)
    {
        $validated = $request->validate([
            'specialization.name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                Rule::unique(Service::class, 'name')->ignore($specialization),
                function ($attribute, $value, $fail) {
                    if (Str::contains($value, ['@', '#', '$', '%', '^', '&', '*'])) {
                        $fail('Название содержит запрещенные символы');
                    }
                },
            ],
            'specialization.description' => [
                'nullable',
                'string',
                'max:2000',
                function ($attribute, $value, $fail) {
                    if (strip_tags($value) !== $value) {
                        $fail('Описание содержит запрещенные HTML-теги');
                    }
                },
            ],
        ]);

        $specialization->fill($validated['specialization']);

        $specialization->save();

        Toast::info('Специализация была сохранена');

        return redirect()->route('platform.specialization');
    }

    /**
     * @throws \Exception
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Specialization $specialization)
    {
        $specialization->delete();

        Toast::info('Специализация была удалена');

        return redirect()->route('platform.specialization');
    }
}
