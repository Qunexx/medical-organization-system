<?php

declare(strict_types=1);

namespace App\Orchid\Screens\User\Doctor;

use App\Enums\RoleEnum;
use App\Http\Requests\EditDoctorRequest;
use App\Models\Avatar;
use App\Models\Doctor;
use App\Models\Role;
use App\Models\Service;
use App\Orchid\Layouts\Role\RolePermissionLayout;
use App\Orchid\Layouts\User\Doctor\DoctorEditLayout;
use App\Orchid\Layouts\User\UserEditLayout;
use App\Orchid\Layouts\User\UserPasswordLayout;
use App\Orchid\Layouts\User\UserRoleLayout;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Orchid\Access\Impersonation;
use App\Models\User;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class DoctorEditScreen extends Screen
{
    /**
     * @var User
     */
    public $user;
    public $doctor;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Doctor $doctor): iterable
    {
        if ($doctor->exists) {
            $doctor->load([
                'specializations',
                'services',
                'user.roles',
            ]);
        }

        $user = $doctor->user ?? new User();

        return [
            'user' => $user,
            'doctor' => $doctor,
            'permission' => $user->exists ? $user->getStatusPermission() : null,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return $this->user->exists ? 'Редактирование врача' : 'Создание врача';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'Данные врача';
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
            DoctorEditLayout::class,
        ];
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(EditDoctorRequest $request, Doctor $doctor)
    {
        $request->validated();

        DB::transaction(function () use ($request, $doctor) {
            $user = $doctor->user ?? new User();
            $userData = $request->input('user');
            unset($userData['password']);
            $user->fill($request->input('user'));
            if (!$user->exists || $request->filled('user.password') || empty($user->password)) {
                $user->password = Hash::make($request->input('user.password'));
            }
            $user->save();
            $doctor->fill($request->input('doctor'));
            $doctor->user_id = $user->id;
            $doctor->save();
            $doctor->specializations()->sync((array)$request->input('doctor.specializations'));
            $doctor->services()->sync((array)$request->input('doctor.services'));

            if ($request->input('remove_avatar') == true) {
                if ($user->avatar && $user->avatar->url) {
                    Storage::disk('public')->delete($user->avatar->url);
                    $user->avatar()->delete();
                }
            }

            if ($request->hasFile('avatar')) {
                if ($user->avatar && $user->avatar->url) {
                    Storage::disk('public')->delete($user->avatar->url);
                }
                $path = $request->file('avatar')
                    ->store(User::AVATAR_PATH, 'public');
                $user->avatar()->updateOrCreate(
                    ['user_id' => $user->id],
                    ['url' => $path]
                );
            }

            if (!$user->hasRole(RoleEnum::DOCTOR)) {
                $role = Role::firstOrCreate([
                    'slug' => RoleEnum::DOCTOR->getLabel()
                ], [
                    'name' => RoleEnum::DOCTOR->getRussianLabel(),
                    'permissions' => []
                ]);
                $user->addRole($role);
            }
        });

        Toast::info($doctor->wasRecentlyCreated ? 'Доктор создан' : 'Данные обновлены');
        return redirect()->route('platform.doctor');
    }

    /**
     * @throws \Exception
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Doctor $doctor)
    {
       $user = $doctor->user();
       $doctor->delete();
       Storage::delete($user->avatar);
       $user->avatar->delete();
       $user->delete();
       Toast::info(__('Врач был удалён'));

        return redirect()->route('platform.doctor');
    }
}
