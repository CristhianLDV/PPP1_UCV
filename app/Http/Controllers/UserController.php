<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Muestra la lista de usuarios
    public function index()
    {
        $users = User::with('roles')->get();
        $roles = Role::all();
        return view('admin.users', compact('users', 'roles'));
    }

    // Almacena un nuevo usuario
    public function store(StoreUserRequest $request)
    {
        $user = new User();
        $this->fillUserData($user, $request);

        flash()->success('Éxito', 'Usuario creado exitosamente.');
        return redirect()->route('users.index');

    }

    // Actualiza los roles de un usuario
   public function update(UpdateUserRequest $request, $id)
    {
         $user = User::findOrFail($id);
        $this->fillUserData($user, $request, $isUpdate = true);

        flash()->success('Éxito', 'Usuario actualizado exitosamente.');
        return redirect()->route('users.index');
    }


    // Elimina los roles de un usuario
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->roles()->detach();
            $user->delete();
        
            flash()->success('Éxito', 'Usuario eliminado correctamente.');
            return redirect()->route('users.index');

        } catch (\Exception $e) {
            
               flash()->error('Error', 'No se pudo eliminar el usuario: ' . $e->getMessage());
        return redirect()->route('users.index');
        }
    }

    // Muestra el perfil del usuario autenticado
    public function showProfile()
    {
        $user = auth()->user();
        return view('profile', compact('user'));
    }

    private function fillUserData(User $user, $request)
    {
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        $user->roles()->sync($request->roles);
    }
}





