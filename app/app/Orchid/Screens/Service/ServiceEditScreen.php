<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Service;

use App\Models\Service;
use App\Orchid\Layouts\Service\ServiceEditLayout;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ServiceEditScreen extends Screen
{

    public $service;
    private $entity;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Service $service): iterable
    {
        return [
            'service' => $service,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return !$this->service->exists ? 'Создание услуги' : 'Редактирование услуги';
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
                ->confirm('После удаления услугу придётся создавать по новой')
                ->canSee($this->service->exists),
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
          ServiceEditLayout::class,
        ];
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Request $request, Service $service)
    {
        $validated = $request->validate([
            'service.name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                Rule::unique(Service::class, 'name')->ignore($service),
                function ($attribute, $value, $fail) {
                    if (Str::contains($value, ['@', '#', '$', '%', '^', '&', '*'])) {
                        $fail('Название содержит запрещенные символы');
                    }
                },
            ],
            'service.description' => [
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

        $service->fill($validated['service']);

        $service->save();

        Toast::info('Услуга была сохранена');

        return redirect()->route('platform.service');
    }

    /**
     * @throws \Exception
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Service $service)
    {
        $service->delete();

        Toast::info('Услуга была удалена');

        return redirect()->route('platform.service');
    }
}
