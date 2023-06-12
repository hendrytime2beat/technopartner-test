<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GeneralModel;
use App\Models\UserModel;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function index()
    {
        return view('user.index', [
            'title' => 'User',
            'pages' => ['User', 'List User']
        ]);
    }

    
    public function list(Request $request)
    {
        $where[] = ['deleted_at', '',  '', 'NULL'];
        $column_order   = ['id', 'profile_picture', 'name_user', 'username', 'last_login'];
        $column_search  = ['profile_picture', 'name_user', 'username', 'last_login'];
        $order = ['id' => 'DESC'];
        $list = GeneralModel::getDatatable('m_users', $column_order, $column_search, $order, $where);
        $data = array();
        $no = $request->post('start');
        foreach ($list as $key) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = '<img onerror="imgError(this)" src="'.asset('assets/img/profile_picture/'.$key->profile_picture).'" style="width:200px;">';
            $row[] = $key->name_user;
            $row[] = $key->username;
            $row[] = \Helper::tanggalwoah($key->last_login);
            $row[] = '
                <a class="btn btn-primary btn-xxs mr-2" href="' . route('user.detail', $key->id) . '"><li class="fa fa-info" aria-hidden="true"></li> Detail</a>
                &nbsp;
                <a class="btn btn-success btn-xxs mr-2" href="' . route('user.edit', $key->id) . '"><li class="fa fa-edit" aria-hidden="true"></li> Edit</a>
                &nbsp;
                <a class="btn btn-danger btn-xxs" onclick="hapus(' . $key->id . ')"><li class="fa fa-trash" aria-hidden="true"></li> Hapus</a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => GeneralModel::countAll('m_users', $where),
            "recordsFiltered" => GeneralModel::countFiltered('m_users', $column_order, $column_search, $order, $where),
            "data" => $data,
        );

        echo json_encode($output);
    }

    public function form(Request $request, $id = '')
    {
        return view('user.form', [
            'title' => 'User',
            'pages' => ['Pemasukkan', 'Tambah Pemasukkan'],
            'data' => $id ? UserModel::find($id) : ''
        ]);
    }
    

    public function act(Request $request, $id='')
    {
        $validator = Validator::make($request->all(), [
            'name_user' => 'required',
            'username' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data = [
            'name_user' => $request->post('name_user'),
            'username' => $request->post('username'),
        ];
        if($request->post('password')){
            $data['password'] = md5($request->post('password'));
        }
        if ($request->hasFile('profile_picture')) {
            $name_file = $request->file('profile_picture')->getClientOriginalName();
            $path = public_path('\assets\img\profile_picture');
            $request->file('profile_picture')->move($path, $name_file);
            $data['profile_picture'] = $name_file;
        }
        if(empty($id)){
            $data['created_at'] = date('Y-m-d H:i:s');
            UserModel::create($data);
            $request->session()->flash('message', 'Sukses!, anda berhasil menambahkan User');
            $id = GeneralModel::getid();
        } else {
            $data['updated_at'] = date('Y-m-d H:i:s');
            UserModel::where('id', $id)->update($data);
            $request->session()->flash('message', 'Sukses!, anda berhasil memperbarui User');
        }
        return redirect()->route('user');
    }
    
    public function detail(Request $request, $id){
        return view('user.detail', [
            'title' => 'Detail User',
            'pages' => [
                'User',
                'Detail'
            ],
            'data' => UserModel::find($id)
        ]);
    }

    public function delete(Request $request, $id){
        UserModel::where('id', $id)->update(['deleted_at' => date('Y-m-d H:i:s')]);
        $request->session()->flash('message', 'Sukses!, anda berhasil menghapus User');
        return redirect()->route('user');
    }

}
