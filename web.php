<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\CadastroController;
use App\Http\Controllers\NotificacaoController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Rota para Login
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});



//Rota para o Home do User
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard', [
        'canRegister' => Route::has('register'),    
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');


require __DIR__.'/auth.php';

//Rota para vue Cadastro de Paciente
Route::get('/cadastropaciente', function () {
    return Inertia::render('Paciente');
})->name('cadastropaciente');

// Rota para cadastro independente
Route::get('/cadastro-paciente', function () {
    return Inertia::render('PacienteIndependente');
})->name('cadastro.paciente');

//Rota para vue Cadastro de Paciente
Route::get('/cadastroanimal', function () {
    return Inertia::render('Cadastro');
})->name('cadastroanimal');
//Rota para vue Lista de Paciente
Route::get('/listapaciente', function () {
    return Inertia::render('Listapaciente');
})->name('listapaciente');

//Rota para vue Documento
Route::get('/documentos', function () {
    return Inertia::render('Documentospaciente');
})->name('documentos');

//Rota para vue Cadastro de Paciente
Route::get('/teste', function () {
    return Inertia::render('Teste');
})->name('teste');

// Rota para vue Adocao de animais
Route::get('/adocao', function () {
    return Inertia::render('Adocao');
})->name('adocao');

//Rota para Registro de Secretaria e Veterinario
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::get('/verificar-animais', [AnimalController::class, 'hasAnimals'])->middleware('auth');

// Rota para cadastro de paciente (tutor) independentemente
Route::get('pacientesind', [PacienteController::class, 'createind'])->name('pacientesind.create');
Route::post('/pacientesind', [PacienteController::class, 'storeind'])->name('pacientesind.store');
Route::get('pacientes', [PacienteController::class, 'create'])->name('pacientes.create');
Route::post('/pacientes', [PacienteController::class, 'store'])->name('pacientes.store');

Route::get('/cadastro-animal', [AnimalController::class, 'create'])->name('animal.create');
Route::post('/cadastro-animal', [AnimalController::class, 'store'])->name('animal.store');

Route::get('/api/animais/sem-dono', [AnimalController::class, 'animaisSemDono']);


Route::get('/users', [UserController::class, 'index']);
Route::get('/animais', [AnimalController::class, 'index']);

// Rota para exibir formulário de cadastro de paciente
Route::get('/pacientes/cadastrar', function () {
    return view('Paciente'); // Arquivo Vue onde está o formulário de cadastro de paciente
})->name('pacientes.form');

// Rota para exibir formulário de cadastro de animais
Route::get('/animais/cadastrar', function () {
    return view('Cadastro'); // Arquivo Vue onde está o formulário de cadastro de animais
})->name('animais.form');

//Rota para Consultas
Route::get('/agendar-consulta', [ConsultaController::class, 'create'])->name('consultas.create');
Route::post('/consultas', [ConsultaController::class, 'store'])->name('consultas.store');
Route::get('/historico-consultas', [ConsultaController::class, 'historico'])->name('consultas.historico');
Route::get('/consultas-futuras', [ConsultaController::class, 'consultar'])->name('consultas.futuras');


//Rota do MailTrap
Route::post('/send-email', [ContactController::class, 'sendEmail']);

//Rota para Editar info da Consulta
Route::get('/info', function () {
    return Inertia::render('InfoConsulta');
})->name('info');

Route::get('/consultas', [ConsultaController::class, 'index']);
Route::put('/consultas/{id}', [ConsultaController::class, 'update']);

Route::get('/allconsultas', [ConsultaController::class, 'allConsultas']);
Route::post('/paciente-chegou', [PacienteController::class, 'pacienteChegou']);
Route::get('/verificar-notificacoes', [NotificacaoController::class, 'verificarNotificacoes']);

