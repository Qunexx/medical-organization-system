<?php

declare(strict_types=1);

namespace app\Orchid\Screens\User\Support;

use App\Enums\RoleEnum;
use App\Http\Requests\EditSupportRequest;
use App\Models\Role;
use App\Orchid\Layouts\Role\RolePermissionLayout;
use App\Orchid\Layouts\User\Support\SupportEditLayout;
use App\Orchid\Layouts\User\UserEditLayout;
use App\Orchid\Layouts\User\UserPasswordLayout;
use App\Orchid\Layouts\User\UserRoleLayout;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Orchid\Access\Impersonation;
use App\Models\User;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class SupportEditScreen extends Screen
{
    /**
     * @var User
     */
    public $user;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(User $user): iterable
    {
        $user->load(['roles']);

        return [
            'user'       => $user,
            'permission' => $user->getStatusPermission(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return $this->user->exists ? 'Редактирование сотрудника поддержки' : 'Создание сотрудника поддержки';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'User profile and privileges, including their associated role.';
    }

    public function permission(): ?iterable
    {
        return [
            'platform.systems.users',
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
            Button::make(__('Remove'))
                ->icon('bs.trash3')
                ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                ->method('remove')
                ->canSee($this->user->exists),

            Button::make(__('Save'))
                ->icon('bs.check-circle')
                ->method('save'),
        ];
    }

    /**
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [
            Layout::block(SupportEditLayout::class)
                ->title(__('Profile Information'))
                ->description(__('Update your account\'s profile information and email address.')),
        ];
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(EditSupportRequest $request, User $user)
    {
        $request->validated();

        DB::transaction(function () use ($request, $user) {
            $user =  $user ?? new User();
            $userData = $request->input('user');
            unset($userData['password']);
            $user->fill($request->input('user'));
            if (!$user->exists || $request->filled('user.password') || empty($user->password)) {
                $user->password = Hash::make($request->input('user.password'));
            }
            $user->save();

            if (!$user->hasRole(RoleEnum::SUPPORT)) {
                $role = Role::firstOrCreate([
                    'slug' => RoleEnum::SUPPORT->getLabel()
                ], [
                    'name' => RoleEnum::SUPPORT->getRussianLabel(),
                    'permissions' => []
                ]);
                $user->addRole($role);
            }
        });

        Toast::info($user->wasRecentlyCreated ? 'Сотрудник поддержки создан' : 'Данные обновлены');
        return redirect()->route('platform.support');
    }

    /**
     * @throws \Exception
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(User $user)
    {
        $user->delete();

        Toast::info(__('User was removed'));

        return redirect()->route('platform.systems.users');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function loginAs(User $user)
    {
        Impersonation::loginAs($user);

        Toast::info(__('You are now impersonating this user'));

        return redirect()->route(config('platform.index'));
    }
}
