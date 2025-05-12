<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Review;

use App\Models\Feedback;
use App\Models\Review;
use App\Models\Service;
use App\Models\Specialization;
use App\Orchid\Layouts\Feedback\FeedbackListLayout;
use App\Orchid\Layouts\Review\ReviewListLayout;
use App\Orchid\Layouts\Specialization\SpecializationListLayout;
use Illuminate\Http\Request;
use Orchid\Platform\Models\Role;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class ReviewListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'reviews' => Review::query()->with(['user','appointment'])->paginate(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return 'Отзывы';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'Здесь находится список отзывов пациентов после консультаций';
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
            ReviewListLayout::class,
        ];
    }

    public function remove(Request $request)
    {
        $review = Review::findOrFail($request->input('id'));
        $review->delete();
        Toast::info('Отзыв успешно удален');
    }
}
