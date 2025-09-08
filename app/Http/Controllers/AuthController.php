<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Afficher le formulaire de connexion
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        
        return view('auth.login');
    }

    /**
     * Traiter la connexion
     */
    public function login(Request $request)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Tentative de connexion avec email ou nom d'utilisateur
        $credentials = $request->only('password');
        $loginField = $request->input('username');

        // Déterminer si c'est un email ou un nom d'utilisateur
        if (filter_var($loginField, FILTER_VALIDATE_EMAIL)) {
            $credentials['email'] = $loginField;
        } else {
            $credentials['name'] = $loginField;
        }

        // Tentative d'authentification
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            
            // Redirection selon le rôle
            $user = Auth::user();
            
            if ($user->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'));
            }else {
                return redirect()->intended(route('user.dashboard'));
            }
        }

        // Échec de la connexion
        session()->flash('error', 'Identifiants incorrects. Veuillez réessayer.');
        
        return redirect()->back()->withInput();
    }

    /**
     * Afficher le formulaire d'inscription
     */
    public function showRegisterForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        
        $roles = Role::all();
        return view('auth.register', compact('roles'));
    }

    /**
     * Traiter l'inscription
     */
    public function register(Request $request)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'nullable|exists:roles,id',
        ], [
            'name.required' => 'Le nom d\'utilisateur est obligatoire.',
            'name.unique' => 'Ce nom d\'utilisateur est déjà pris.',
            'email.required' => 'L\'adresse email est obligatoire.',
            'email.email' => 'Veuillez saisir une adresse email valide.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Créer l'utilisateur
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => $request->role_id ?? 2, // Par défaut: utilisateur
            ]);

            // Connexion automatique
            Auth::login($user);

            session()->flash('success', 'Compte créé avec succès ! Bienvenue ' . $user->name);

            // Redirection selon le rôle
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->isModerator()) {
                return redirect()->route('moderator.dashboard');
            } else {
                return redirect()->route('user.dashboard');
            }

        } catch (\Exception $e) {
            session()->flash('error', 'Une erreur s\'est produite lors de la création du compte.');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Déconnexion
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        session()->flash('success', 'Vous avez été déconnecté avec succès.');
        
        return redirect()->route('login');
    }

    /**
     * Tableau de bord admin
     */
    public function adminDashboard()
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Accès non autorisé.');
        }

        $users = User::with('role')->get();
        $totalUsers = User::count();
        $totalAdmins = User::whereHas('role', function($query) {
            $query->where('name', 'admin');
        })->count();

        return view('admin.dashboard', compact('users', 'totalUsers', 'totalAdmins'));
    }

    /**
     * Gestion des utilisateurs (Admin uniquement)
     */
    public function manageUsers()
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Accès non autorisé.');
        }

        $users = User::with('role')->paginate(15);
        $roles = Role::all();

        return view('admin.users.index', compact('users', 'roles'));
    }

    /**
     * Éditer un utilisateur
     */
    public function editUser($id)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Accès non autorisé.');
        }

        $user = User::with('role')->findOrFail($id);
        $roles = Role::all();

        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Mettre à jour un utilisateur
     */
    public function updateUser(Request $request, $id)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Accès non autorisé.');
        }

        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:users,name,' . $id,
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'role_id' => 'required|exists:roles,id',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        session()->flash('success', 'Utilisateur mis à jour avec succès.');
        return redirect()->route('admin.users.list');
    }

    /**
     * Supprimer un utilisateur
     */
    public function deleteUser($id)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Accès non autorisé.');
        }

        $user = User::findOrFail($id);

        // Empêcher la suppression de son propre compte
        if ($user->id === Auth::id()) {
            session()->flash('error', 'Vous ne pouvez pas supprimer votre propre compte.');
            return redirect()->back();
        }

        $user->delete();

        session()->flash('success', 'Utilisateur supprimé avec succès.');
        return redirect()->route('admin.users.list');
    }

    /**
     * Profil utilisateur
     */
    public function profile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    /**
     * Mettre à jour le profil
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:users,name,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'current_password' => 'required_with:password|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Vérifier le mot de passe actuel si un nouveau mot de passe est fourni
        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
            }
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        session()->flash('success', 'Profil mis à jour avec succès.');
        return redirect()->back();
    }

    /**
     * Obtenir les utilisateurs en ligne (API)
     */
    public function getOnlineUsers()
    {
        $onlineUsers = User::whereNotNull('last_seen')
            ->where('last_seen', '>=', now()->subMinutes(5))
            ->count();

        return response()->json(['online_users' => $onlineUsers]);
    }
}