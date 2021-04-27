<?php

namespace App\Controllers;

use App\Models\Model_user;
use App\Models\Model_dep;

class User extends BaseController
{

    public function __construct()
    {
        $this->Model_user = new Model_user();
        $this->Model_dep = new Model_dep();
        helper('form');
    }

	public function index()
	{
		$data = array(
            'title' => 'User',
            'user'  => $this->Model_user->all_data(),
			'isi'   => 'user/v_index'
		);
		return view('layout/v_wrapper',$data);
    }
    
    public function add()
    {
        $data = array(
            'title' => 'Add User',
            'dep'   => $this->Model_dep->all_data(),
			'isi'   => 'user/v_add'
        );
        return view('layout/v_wrapper',$data);
    }

    public function insert()
    {
        if ($this->validate([
            'nama_user' => [
                'label'  => 'Nama User',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Wajib Di Isi !'
                ]
            ],
            'email' => [
                'label'  => 'E-mail',
                'rules'  => 'required|is_unique[tbl_user.email]',
                'errors' => [
                    'required' => '{field} Wajib Di Isi !',
                    'is_unique' => '{field} Sudah Di Ambil !',
                ]
            ],
            'password' => [
                'label'  => 'Password',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Wajib Di Isi !'
                ]
            ],
            'level' => [
                'label'  => 'Level',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Wajib Di Isi !'
                ]
            ],
            'id_dep' => [
                'label'  => 'Departement',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Wajib Di Isi !'
                ]
            ],
            'foto' => [
                'label'  => 'Foto',
                'rules'  => 'uploaded[foto]|max_size[foto,1024]|mime_in[foto,image/png,image/jpg,image/gif,image/jpeg]',
                'errors' => [
                    'uploaded' => '{field} Wajib Di Isi !',
                    'max_size' => 'Ukuran {field} Max 1024 KB !',
                    'mime_in' => 'Format {field} Tidak Sesuai !',
                ]
            ]
                
        ])) {
            $foto = $this->request->getFile('foto');
            $nama_file = $foto->getRandomName();
            //jika valid
            $data = array(
                'nama_user' => $this->request->getPost('nama_user'),
                'email' => $this->request->getPost('email'),
                'password' => $this->request->getPost('password'),
                'level' => $this->request->getPost('level'),
                'id_dep' => $this->request->getPost('id_dep'),
                'foto' => $nama_file,
            );

            $foto->move('foto', $nama_file);
            $this->Model_user->add($data);
            session()->setFlashdata('pesan','Data Berhasil Di Tambahkan !');
            return redirect()->to(base_url('user'));
        }else{
            //jika tidak valid
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->to(base_url('user/add'));
        }
    }

    

    public function edit($id_user)
    {
        $data = array(
            'title' => 'Edit User',
            'dep'   => $this->Model_dep->all_data(),
            'user'  => $this->Model_user->detail_data($id_user),
			'isi'   => 'user/v_edit'
        );
        return view('layout/v_wrapper',$data);
    }

    public function update($id_user)
    {
        if ($this->validate([
            'nama_user' => [
                'label'  => 'Nama User',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Wajib Di Isi !'
                ]
            ],
            'password' => [
                'label'  => 'Password',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Wajib Di Isi !'
                ]
            ],
            'level' => [
                'label'  => 'Level',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Wajib Di Isi !'
                ]
            ],
            'id_dep' => [
                'label'  => 'Departement',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Wajib Di Isi !'
                ]
            ],
            'foto' => [
                'label'  => 'Foto',
                'rules'  => 'max_size[foto,1024]|mime_in[foto,image/png,image/jpg,image/gif,image/jpeg]',
                'errors' => [
                    'max_size' => 'Ukuran {field} Max 1024 KB !',
                    'mime_in' => 'Format {field} Tidak Sesuai !',
                ]
            ]
                
        ])) {
            $foto = $this->request->getFile('foto');

            if ($foto->getError() == 4) {
                $data = array(
                    'id_user' => $id_user,
                    'nama_user' => $this->request->getPost('nama_user'),
                    'password' => $this->request->getPost('password'),
                    'level' => $this->request->getPost('level'),
                    'id_dep' => $this->request->getPost('id_dep'),
                    //'foto' => $nama_file,
                );
    
                //$foto->move('foto', $nama_file);
                $this->Model_user->edit($data);
            }else{
                $user = $this->Model_user->detail_data($id_user);
                if ($user['foto'] !=  "") {
                    unlink('foto/'.$user['foto']);
                }
                $nama_file = $foto->getRandomName();
                $data = array(
                    'id_user' => $id_user,
                    'nama_user' => $this->request->getPost('nama_user'),
                    'password' => $this->request->getPost('password'),
                    'level' => $this->request->getPost('level'),
                    'id_dep' => $this->request->getPost('id_dep'),
                    'foto' => $nama_file,
                );
    
                $foto->move('foto', $nama_file);
                $this->Model_user->edit($data);
            }
           // $foto = $this->request->getFile('foto');
            //$nama_file = $foto->getRandomName();
            //jika valid
            
            session()->setFlashdata('pesan','Data Berhasil Di Update !');
            return redirect()->to(base_url('auth'));
        }else{
            //jika tidak valid
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->to(base_url('user/edit'.$id_user));
        } 
    }
    public function delete($id_user)
    {
        $user = $this->Model_user->detail_data($id_user);
        if ($user['foto'] !=  "") {
            unlink('foto/'.$user['foto']);
        }
        $data = array(
            'id_user' => $id_user,
    );
        $this->Model_user->delete_data($data);
        session()->setFlashdata('pesan','Data Berhasil Di Hapus !');
        return redirect()->to(base_url('user'));
    }
	//--------------------------------------------------------------------

}
