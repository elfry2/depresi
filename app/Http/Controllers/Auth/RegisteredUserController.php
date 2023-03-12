<?php

namespace App\Http\Controllers\Auth;

use App\Models\Role;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use App\Http\Controllers\PreferenceController;
use App\Models\Preference;

class RegisteredUserController extends Controller
{
    public function index(Request $request)
    {
        $data = [
            'title' => 'Pengguna',
            'resource' => 'users',
            'items' => new User,
            'items2' => Role::all()
        ];

        if(request('q'))
        $data['items']
        = $data['items']->where('name', 'like', '%' . request('q') . '%');

        $data['preferences'] = [
            'sorting'
            => PreferenceController::get($data['resource'] . 'Sorting') ?: 'id',
            'sortingDirection' => PreferenceController::get(
                $data['resource'] . 'SortingDirection') ?: 'asc'
        ];

        $data['items'] = $data['items']->orderBy($data['preferences'][
            'sorting'], $data['preferences']['sortingDirection']);

        $data['items'] = $data['items']->paginate(config('app.itemsPerPage'));

        return view('dashboard.' . $data['resource'] . '.index', $data);
    }

    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register', [
            'items' => Role::orderBy('id', 'desc')->get()
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $roleIds = [];

        foreach(Role::select('id')->get() as $role) {
            array_push($roleIds, $role->id);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role_id' => ['integer', Rule::in($roleIds)]
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id
        ]);

        event(new Registered($user));

        // Auth::login($user);

        // return redirect(RouteServiceProvider::HOME);
        return redirect('/users');
    }

    public function destroy(User $user)
    {
        Preference::where('user_id', $user->id)->delete();
        
        $user->delete();

        return redirect('/users')
        ->with('message', (object) [
            'type' => 'success',
            'content' => 'Pengguna berhasil dihapus.'
        ]);
    }

    public function update(User $user, Request $request)
    {
        $roleIds = [];

        foreach(Role::select('id')->get() as $role) {
            array_push($roleIds, $role->id);
        }
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role_id' => ['integer', Rule::in($roleIds)]
        ]);

        if($request->email !== $user->email) {
            $request->validate([
                'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class]
            ]);
        }

        if($request->password) {
            $request->validate([
                'password' => ['required', 'max:255'],
            ]);

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => $request->role_id
            ]);   
        } else $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id
        ]);

        return redirect('/users')
        ->with('message', (object) [
            'type' => 'success',
            'content' => 'Pengguna berhasil disunting.'
        ]);
    }
}
