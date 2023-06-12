<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GeneralModel;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    public function index()
    {
        $saldo = GeneralModel::getRow('m_saldo', 'saldo', 'WHERE deleted_at IS NULL');
        return view('dashboard.index', [
            'title' => 'Dashboard',
            'pages' => ['Dashboard'],
            'data' => [
                'transactions' => GeneralModel::getRes('tb_report', '*', 'WHERE deleted_at IS NULL ORDER BY id DESC LIMIT 20'),
                'saldo' => $saldo ? $saldo->saldo : 0
            ]
        ]);
    }
}
