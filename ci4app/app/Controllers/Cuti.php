<?php
namespace App\Controllers;

use App\Models\CutiModel;
use App\Models\EmployeeModel;

class Cuti extends BaseController
{
    protected $cutiModel;
    protected $employeeModel;

    public function __construct()
    {
        $this->cutiModel = new CutiModel();
        $this->employeeModel = new EmployeeModel();
    }

    public function index()
    {
        $data['cuti'] = $this->cutiModel->getJoin()->findAll();
        $data['pegawai'] = $this->employeeModel->findAll();
        return view('cuti/index', $data);
    }

    public function create()
    {
        $data['pegawai'] = $this->employeeModel->findAll();
        return view('cuti/create', $data);
    }

    public function save()
    {
        $data = [
            'pegawai_id' => $this->request->getPost('pegawai_id'),
            'tanggal_awal' => $this->request->getPost('tanggal_awal'),
            'tanggal_akhir' => $this->request->getPost('tanggal_akhir'),
            'jenis' => $this->request->getPost('jenis'),
            'alasan' => $this->request->getPost('alasan'),
            'status' => 'Menunggu',
            'created_at' => date('Y-m-d H:i:s'),
        ];
        $this->cutiModel->insert($data);
        // notify HR via email
        $email = service('email');
        $hrEmails = array_map('trim', explode(',', getenv('HR_EMAILS') ?: ''));
        foreach ($hrEmails as $hr) {
            $email->setTo($hr);
            $email->setSubject('Permohonan Cuti Baru');
            $email->setMessage('Pegawai ID '.$data['pegawai_id'].' mengajukan cuti.');
            $email->send();
        }
        session()->setFlashdata('success', 'Permohonan cuti dikirim.');
        return redirect()->to('/cuti');
    }

    public function edit($id)
    {
        $data['cuti'] = $this->cutiModel->find($id);
        return view('cuti/edit', $data);
    }

    public function update($id)
    {
        $status = $this->request->getPost('status');
        $this->cutiModel->update(
            $id,
            [
                'status' => $status,
                'alasan_penolakan' => $this->request->getPost('alasan_penolakan'),
            ]
        );
        if ($status === 'Disetujui') {
            $cuti = $this->cutiModel->find($id);
            $start = new \DateTime($cuti['tanggal_awal']);
            $end = new \DateTime($cuti['tanggal_akhir']);
            $days = $start->diff($end)->days + 1;
            $pegawai = $this->employeeModel->find($cuti['pegawai_id']);
            $this->employeeModel->update($pegawai['id'], [
                'sisa_cuti' => max(0, $pegawai['sisa_cuti'] - $days),
            ]);
        }
        session()->setFlashdata('success', 'Permohonan cuti diperbarui.');
        return redirect()->to('/cuti');
    }
}
