<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Carrega todos os usuários com paciente_id diferente de null
        $users = User::whereNotNull('paciente_id')->get(); // Isso retorna apenas usuários com paciente_id definido
        return response()->json($users);
    }
}
