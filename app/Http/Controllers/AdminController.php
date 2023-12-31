<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Login;
use App\Models\Ocasiao;
use App\Models\Combinacao;
use App\Models\TipoCorporal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct()
    {
        // Adicione o middleware de autenticação apenas para métodos específicos
        $this->middleware('admin')->only(['logout']);
    }
    public function registerForm()
    {
        return view('admin.register');
    }

    public function loginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        // Validação dos campos de entrada
        $request->validate([
            'email' => 'required|email',
            'senha' => 'required',
        ]);
    
        $credentials = $request->only('email', 'senha');
    
        // Verificar se o usuário existe com base no e-mail
        $user = Login::where('email', $credentials['email'])->first();

        dd($user);
    
        if ($user) {
            // Se o usuário existe, verificar a senha
            if (Hash::check($credentials['senha'], $user->senha)) {
                // Autenticação bem-sucedida
                if ($user->type === 'cliente') {
                    dd('Deu certo - Cliente', $user);  // Mostrar mensagem e detalhes do usuário
                    auth()->guard('login')->login($user);
                    return redirect('/profile');
                } elseif ($user->type === 'empresa') {
                    dd('Deu certo - Empresa', $user);  // Mostrar mensagem e detalhes do usuário
                    auth()->guard('login')->login($user);
                    return redirect('/dashboard');
                }
            }
        }
    
    

    }    

    public function register(Request $request)
    {
        // Validação dos dados de entrada
        $request->validate([
            'email' => 'required|string|email|unique:login',
            'senha' => 'required|string|min:8',
            'nome_admin' => 'required|string|max:50',
            'sobrenome_admin' => 'required|string|max:80',
            'cpf_admin' => 'required|string|max:20|unique:administrador',
            'telefone' => 'required|string|max:15',
            'dtanasc_admin' => 'required|date',
            'dtaadmissao_admin' => 'required|date',
        ]);

        // Crie o registro de login
        $login = new Login();
        $login->email = $request->input('email');
        $login->senha = Hash::make($request->input('senha'));
        $login->type = 'admin';
        $login->save();

        // Crie o registro de administrador associado ao login
        $admin = new Admin();
        $admin->cod_login = $login->id;
        $admin->img_admin = $request->input('img_admin');
        $admin->nome_admin = $request->input('nome_admin');
        $admin->sobrenome_admin = $request->input('sobrenome_admin');
        $admin->cpf_admin = $request->input('cpf_admin');
        $admin->telefone_admin = $request->input('telefone');
        $admin->dtanasc_admin = $request->input('dtanasc_admin');
        $admin->dtaadmissao_admin = $request->input('dtaadmissao_admin');
        $admin->save();

        return redirect()->route('admin'); // Redirecione para a página de dashboard do administrador ou outra ação apropriada
    }

    public function logout(Request $request)
    {
        Auth::logout(); // Logout do usuário autenticado
        $request->session()->invalidate(); // Invalida a sessão
        $request->session()->regenerateToken(); // Regenera o token de sessão

        return redirect('/'); // Redireciona para a página inicial ou outra ação apropriada
    }

    public function home()
    {
        return view('admin.home');
    }

    public function dadospessoais()
    {
        // Verifique se o usuário está autenticado como admin
        if (!Auth::guard('login')->check()) {
            return redirect()->route('login'); // Redirecione para a página de login do admin se não estiver autenticado.
        }

        $login = Auth::guard('login')->user();
        $admin = Admin::where('login_id', $login->id)->first();

        if ($admin) {
            return view('admin.partials.dadospessoais', compact('admin', 'login'));
        }

        // Lidar com o caso em que os dados não foram encontrados
        return redirect()->route('login'); // Redirecione para a página de login do admin ou ação apropriada
    }

    public function tipos()
    {
        $tipos = TipoCorporal::all();
        return view('admin.partials.tipos', compact('tipos'));
    }

    public function cadastros()
    {
        return view('admin.partials.cadastros');
    }

    public function departamentos()
    {
        $ocasioes = Ocasiao::all();
        return view('admin.partials.departamentos', compact('ocasioes'));
    }

    public function estilos()
    {
        return view('admin.partials.estilos');
    }

    public function info()
    {
        return view('admin.partials.info');
    }

    public function solicitacoes()
    {
        return view('admin.partials.solicitacoes');
    }

    public function combinacoes()
    {
        // Supondo que $combinacoes seja uma coleção de dados recuperados do banco de dados
        $combinacoes = Combinacao::all(); // Substitua Combinacao pelo nome correto do seu modelo
    
        return view('admin.partials.combinacoes', ['combinacoes' => $combinacoes]);
    }

}