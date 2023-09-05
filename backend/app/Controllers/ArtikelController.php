<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Artikel;
use CodeIgniter\API\ResponseTrait;

class ArtikelController extends BaseController
{
    use ResponseTrait;

    protected $model;

    public function __construct()
    {
        $this->model = new Artikel;
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');

        $data = [
            'message'=>'all artikel',
            'data'=> $this->model->getAllArtikel($keyword)
        ];

        return $this->respond($data, 200);
    }

    public function show($id)
    {
        $data = [
            'message'=>'detail artikel',
            'data'=> $this->model->getArtikelById($id)
        ];

        return $this->respond($data, 200);
    }

    public function create()
    {
        $rules = [
            'judul' => [
                'rules'  => 'required|is_unique[artikel.judul]',
                'errors' => [
                    'required' => 'Judul harus di isi',
                    'is_unique' => 'Judul sudah terdaftar'
                ],
            ],
            'kategori' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Kategori harus di isi',
                ],
            ],
            'konten' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Konten harus di isi',
                ],
            ],
            'thumbnail' => [
                'rules'  => 'uploaded[thumbnail]|max_size[thumbnail,2048]|mime_in[thumbnail,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Thumbnail harus di upload',
                    'max_size' => 'Ukuran thumbnail maksimal 2 MB',
                    'mime_in' => 'Format thumbnail harus jpg/jpeg/png',
                ],
            ],
            'penulis' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Penulis harus di isi',
                ],
            ]
        ];

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors(), 400);
        }

        // upload
        $thumbnail = $this->request->getFile('thumbnail');
        $namaThumbnail = $thumbnail->getRandomName();
        $thumbnail->move('thumbnail/', $namaThumbnail);
        
        $this->model->insert([
            'judul' => $this->request->getVar('judul'),
            'kategori' => $this->request->getVar('kategori'),
            'slug' => str_replace(' ', '-', $this->request->getVar('judul')),
            'konten' => $this->request->getVar('konten'),
            'thumbnail' => $namaThumbnail,
            'penulis' => $this->request->getVar('penulis'),
        ]);

        $data = [
            'message' => 'add artikel successfully'
        ];

        return $this->respondCreated($data);
    }

    public function update($id)
    {
        $rules1 = [
            'judul' => [
                'rules'  => "required|is_unique[artikel.judul,id,{$id}]",
                'errors' => [
                    'required' => 'Judul harus di isi',
                    'is_unique' => 'Judul sudah terdaftar'
                ],
            ],
            'kategori' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Kategori harus di isi',
                ],
            ],
            'konten' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Konten harus di isi',
                ],
            ],
            'thumbnail' => [
                'rules'  => 'max_size[thumbnail,2048]|mime_in[thumbnail,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran thumbnail maksimal 2 MB',
                    'mime_in' => 'Format thumbnail harus jpg/jpeg/png',
                ],
            ],
            'penulis' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Penulis harus di isi',
                ],
            ]
        ];
        $rules2 = [
            'judul' => [
                'rules'  => "required|is_unique[artikel.judul,id,{$id}]",
                'errors' => [
                    'required' => 'Judul harus di isi',
                    'is_unique' => 'Judul sudah terdaftar'
                ],
            ],
            'kategori' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Kategori harus di isi',
                ],
            ],
            'konten' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Konten harus di isi',
                ],
            ],
            'penulis' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Penulis harus di isi',
                ],
            ]
        ];

        $thumbnail = $this->request->getFile('thumbnail');

        if (!$this->validate($thumbnail == null ? $rules2 : $rules1)) {
            return $this->fail($this->validator->getErrors(), 400);
        }
        
        // cek artikel by id
        $artikel = $this->model->getArtikelById($id);
        
        // upload
        if($thumbnail !== null){
            if($thumbnail->isValid()){
                $namaThumbnail = $thumbnail->getRandomName();
                $thumbnail->move('thumbnail/', $namaThumbnail);
    
                unlink('thumbnail/'. $artikel->thumbnail);
            }else{
                $namaThumbnail = $artikel->thumbnail;
            }
        }else{
            $namaThumbnail = $artikel->thumbnail;
        }
        
        $this->model->update($id, [
            'judul' => $this->request->getVar('judul'),
            'kategori' => $this->request->getVar('kategori'),
            'slug' => str_replace(' ', '-', $this->request->getVar('judul')),
            'konten' => $this->request->getVar('konten'),
            'thumbnail' => $namaThumbnail,
            'penulis' => $this->request->getVar('penulis'),
        ]);

        $data = [
            'message' => 'update artikel successfully'
        ];

        return $this->respondCreated($data);
    }

    public function delete($id)
    {
        // cek artikel by id dan hapus gambar
        $artikel = $this->model->getArtikelById($id);
        unlink('thumbnail/'. $artikel->thumbnail);

        $this->model->delete($id);

        $data = [
            'message' => 'delete artikel successfully'
        ];

        return $this->respondDeleted($data);
    }

    public function home()
    {
        $keyword = $this->request->getGet('keyword');

        $data = [
            'message'=>'all artikel',
            'data'=> $this->model->getAllArtikel($keyword)
        ];

        return $this->respond($data, 200);
    }

    public function show_home($id)
    {
        // cek artikel by id
        $artikel = $this->model->getArtikelById($id);

        // update view
        $this->model->update($id, [
            'view' => $artikel->view + 1,
        ]);


        $data = [
            'message'=>'detail artikel',
            'data'=> $this->model->getArtikelById($id)
        ];

        return $this->respond($data, 200);
    }
}
