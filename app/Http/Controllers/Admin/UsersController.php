<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Documento;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin.users.index')->only('index');
        $this->middleware('can:admin.users.edit')->only('edit', 'update');
        $this->middleware('can:admin.users.create')->only('create', 'store');
        $this->middleware('can:admin.users.destroy')->only('destroy');
        
    }

    public function index()
    {
        return view('admin.users.index');
    }

    public function create()
    {
        $roles = Role::all();
        $documentos = Documento::all()->mapWithKeys(function ($documento) {
            return [$documento->id => $documento->nombre . ' (' . $documento->cantidadDigitos . ' dígitos)'];
        });
        return view('admin.users.create', compact('documentos', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'apellidos' => 'required',
            'telefono' => 'required',
            'email' => 'required|email|unique:users,email', // Validación para el campo email
            'password' => 'required|min:8', // Validación para la contraseña
            'direccion' => 'required',
            'documento_id' => 'required', // Asegurar que se seleccione un tipo de documento
            'numeroDoc' => 'required|unique:users,numeroDoc', // Asegurar que el número de documento sea único
        ], [
            'name.required' => 'El nombre es requerido.',
            'apellidos.required' => 'Los apellidos son requeridos.',
            'telefono.required' => 'El teléfono es requerido.',
            'email.required' => 'El correo electrónico es requerido.',
            'email.email' => 'El correo electrónico debe tener un formato válido.',
            'email.unique' => 'El correo electrónico ya está en uso.',
            'password.required' => 'La contraseña es requerida.',
            'password.min' => 'La contraseña debe tener al menos :min caracteres.',
            'direccion.required' => 'La dirección es requerida.',
            'documento_id.required' => 'Por favor seleccione un tipo de documento.',
            'numeroDoc.required' => 'El número de documento es requerido.',
            'numeroDoc.unique' => 'El número de documento ya está en uso.',
        ]);
        // Crear un nuevo usuario y asignar los valores de los campos del formulario
        $user = new User();
        $user->name = $request->name;
        $user->apellidos = $request->apellidos;
        $user->telefono = $request->telefono;
        $user->email = $request->email;
        $user->password = bcrypt($request->password); // Encriptar la contraseña antes de guardarla
        $user->direccion = $request->direccion;
        $user->documento_id = $request->documento_id;
        $user->numeroDoc = $request->numeroDoc;

        // Guardar el usuario en la base de datos
        $user->save();
        return redirect()->route('admin.users.index', $user)->with('info', 'El Trabajador se creó con éxito');
    }

    public function show(User $user)
    {
    }

    public function edit(User $user)
    {
        $documentos = Documento::all()->mapWithKeys(function ($documento) {
            return [$documento->id => $documento->nombre . ' (' . $documento->cantidadDigitos . ' dígitos)'];
        });

        // Obtener la contraseña desencriptada del usuario
        $currentPassword = $user->password;

        $roles = Role::all();

        return view('admin.users.edit', compact('user', 'documentos', 'currentPassword', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'documento_id' => 'required|exists:documentos,id',
            'numeroDoc' => 'required|string|max:255',
            'vigente' => 'required|boolean',
            'roles' => 'nullable|array',
        ]);

        // Actualizar los datos del usuario
        $user->update($validatedData);

        // Actualizar los roles del usuario
        if ($request->has('roles')) {
            $user->roles()->sync($request->roles);
        } else {
            // Si no se seleccionaron roles, eliminar todos los roles asociados al usuario
            $user->roles()->detach();
        }

        return redirect()->route('admin.users.index')->with('success', 'Usuario actualizado exitosamente.');
    }


    // public function update(Request $request, User $user)
    // {
    //     // // Validar los datos del formulario
    //     // $request->validate([
    //     //     'name' => 'required',
    //     //     'apellidos' => 'required',
    //     //     'telefono' => 'required',
    //     //     'email' => 'required|email|unique:users,email,' . $user->id, // Asegurar que el email sea único, ignorando el del usuario actual
    //     //     'password' => 'nullable|min:8', // La contraseña es opcional y debe tener al menos 8 caracteres si se proporciona
    //     //     'direccion' => 'required',
    //     //     'documento_id' => 'required',
    //     //     'numeroDoc' => 'required|unique:users,numeroDoc,' . $user->id, // Asegurar que el número de documento sea único, ignorando el del usuario actual
    //     // ]);

    //     // Actualizar los campos del usuario con los nuevos valores
    //     $user->update([
    //         'name' => $request->name,
    //         'apellidos' => $request->apellidos,
    //         'telefono' => $request->telefono,
    //         'email' => $request->email,
    //         'password' => $request->password ? bcrypt($request->password) : $user->password, // Hashear la nueva contraseña si se proporciona, de lo contrario mantener la misma
    //         'direccion' => $request->direccion,
    //         'documento_id' => $request->documento_id,
    //         'numeroDoc' => $request->numeroDoc,
    //     ]);

    //     // Redirigir a la vista de índice de usuarios con un mensaje de éxito
    //     return redirect()->route('admin.users.index')->with('info', 'El Trabajador se actualizó con éxito');
    // }



    public function destroy(User $user)
    {
        $user->delete();

        // Redireccionar a la página de índice con un mensaje informativo
        return redirect()->route('admin.users.index')->with('info', 'El Trabajador se eliminó con éxito');
    }
}
