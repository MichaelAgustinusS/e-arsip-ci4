<?php

namespace App\Controllers;

use App\Models\Model_arsip;
use App\Models\Model_kategori;

class Arsip extends BaseController
{
    public function __construct()
    {
        $this->Model_arsip = new Model_arsip();
        $this->Model_kategori = new Model_kategori();
        helper('form');
    }

	public function index()
	{
		$data = array(
            'title' => 'Arsip',
            'arsip' => $this->Model_arsip->all_data(),
			'isi'   => 'arsip/v_index'
		);
		return view('layout/v_wrapper',$data);
	}

    public function add()
    {
        $data = array(
            'title' => 'Add Arsip',
            'kategori' => $this->Model_kategori->all_data(),
			'isi'   => 'arsip/v_add'
		);
		return view('layout/v_wrapper',$data);
    }

    public function insert()
    {
        if ($this->validate([
            'nama_arsip' => [
                'label'  => 'Nama Arsip',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Wajib Di Isi !',
                ]
            ],
            'id_kategori' => [
                'label'  => 'Id Kategori',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Wajib Di Isi !'
                ]
            ],
            'deskripsi' => [
                'label'  => 'Deskripsi',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Wajib Di Isi !'
                ]
            ],
            'file_arsip' => [
                'label'  => 'File Arsip',
                'rules'  => 'uploaded[file_arsip]|max_size[file_arsip,4096]|ext_in[file_arsip,pdf]',
                'errors' => [
                    'uploaded' => '{field} Wajib Di Isi !',
                    'max_size' => 'Ukuran {field} Max 4096 KB !',
                    'ext_in' => 'Format {field} Harus .pdf !',
                ]
            ]
                
        ])) {
            $file_arsip = $this->request->getFile('file_arsip');
            $nama_file = $file_arsip->getRandomName();
            $ukuran_file = $file_arsip->getSize();
            //jika valid
            $data = array(
                'id_kategori' => $this->request->getPost('id_kategori'),
                'no_arsip' => $this->request->getPost('no_arsip'),
                'nama_arsip' => $this->request->getPost('nama_arsip'),
                'deskripsi' => $this->request->getPost('deskripsi'),
                'tgl_upload' => date('Y-m-d'),
                'tgl_update' => date('Y-m-d'),
                'id_dep' => session()->get('id_dep'),
                'id_user' => session()->get('id_user'),
                'file_arsip' => $nama_file,
                'ukuran_file' => $ukuran_file,
            );

            $file_arsip->move('file_arsip', $nama_file);
            $this->Model_arsip->add($data);
            session()->setFlashdata('pesan','Data Berhasil Di Tambahkan !');
            return redirect()->to(base_url('arsip'));
        }else{
            //jika tidak valid
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->to(base_url('arsip/add'));
        }
    }

    public function edit($id_arsip)
    {
        $data = array(
            'title' => 'Edit Arsip',
            'kategori' => $this->Model_kategori->all_data(),
            'arsip' => $this->Model_arsip->detail_data($id_arsip),
			'isi'   => 'arsip/v_edit'
		);
		return view('layout/v_wrapper',$data);
    }

    public function update($id_arsip)
    {
        if ($this->validate([
            'nama_arsip' => [
                'label'  => 'Nama Arsip',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Wajib Di Isi !',
                ]
            ],
            'id_kategori' => [
                'label'  => 'Id Kategori',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Wajib Di Isi !'
                ]
            ],
            'deskripsi' => [
                'label'  => 'Deskripsi',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Wajib Di Isi !'
                ]
            ],
            'file_arsip' => [
                'label'  => 'File Arsip',
                'rules'  => 'max_size[file_arsip,4096]|ext_in[file_arsip,pdf]',
                'errors' => [
                    'max_size' => 'Ukuran {field} Max 4096 KB !',
                    'ext_in' => 'Format {field} Harus .pdf !',
                ]
            ]
                
        ])) {
            $file_arsip = $this->request->getFile('file_arsip');
            if ($file_arsip->getError() == 4 ) {
            //jika file tidak diganti
            $data = array(
                'id_arsip' => $id_arsip,
                'id_kategori' => $this->request->getPost('id_kategori'),
                'no_arsip' => $this->request->getPost('no_arsip'),
                'nama_arsip' => $this->request->getPost('nama_arsip'),
                'deskripsi' => $this->request->getPost('deskripsi'),
                'tgl_update' => date('Y-m-d'),
                'id_dep' => session()->get('id_dep'),
                'id_user' => session()->get('id_user'),
            );
            $this->Model_arsip->edit($data);
            }else{
            //jika file diganti
            $arsip = $this->Model_arsip->detail_data($id_arsip);
            if ($arsip['file_arsip'] != "") {
                unlink('file_arsip/' . $arsip['file_arsip']);
                }
                $nama_file = $file_arsip->getRandomName();
                $ukuran_file = $file_arsip->getSize();
                //jika valid
                $data = array(
                    'id_arsip' => $id_arsip,
                    'id_kategori' => $this->request->getPost('id_kategori'),
                    'no_arsip' => $this->request->getPost('no_arsip'),
                    'nama_arsip' => $this->request->getPost('nama_arsip'),
                    'deskripsi' => $this->request->getPost('deskripsi'),
                    'tgl_update' => date('Y-m-d'),
                    'id_dep' => session()->get('id_dep'),
                    'id_user' => session()->get('id_user'),
                    'file_arsip' => $nama_file,
                    'ukuran_file' => $ukuran_file,
                );
    
                $file_arsip->move('file_arsip', $nama_file);
                $this->Model_arsip->edit($data);    
            }
            session()->setFlashdata('pesan','Data Berhasil Diupdate !');
            return redirect()->to(base_url('arsip'));
        }else{
            //jika tidak valid
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->to(base_url('arsip/edit' .$id_arsip));
        }
    }

    public function delete($id_arsip)
    {
        $arsip = $this->Model_arsip->detail_data($id_arsip);
        if ($arsip['file_arsip'] != "") {
            unlink('file_arsip/' . $arsip['file_arsip']);
        }
        $data = array(
            'id_arsip' => $id_arsip,
    );
        $this->Model_arsip->delete_data($data);
        session()->setFlashdata('pesan','Arsip Berhasil Di Hapus !');
        return redirect()->to(base_url('arsip'));
    }

    public function viewpdf($id_arsip)
    {
        $data = array(
            'title' => 'View Arsip',
            'arsip' => $this->Model_arsip->detail_data($id_arsip),
			'isi'   => 'arsip/v_viewpdf'
		);
		return view('layout/v_wrapper',$data);
    }
	//--------------------------------------------------------------------

}
