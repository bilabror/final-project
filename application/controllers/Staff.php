<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Staff extends CI_Controller {

  public function __construct() {
    parent::__Construct();
    isLogin();
    isStaff();
  }

  public function dashboard() {

    $data['title'] = 'Dashboard';
    $data['staff'] = $this->db->get_where('user', ['role' => 'staff'])->num_rows();
    view('staff/dashboard', $data);
  }

  public function list_doc() {
    $data['title'] = 'List Pengajuan Dokumen';
    $data['documents'] = $this->db->get('document')->result();
    $data['success_documents'] = $this->db->get_where('document', ['document_status' => 'setuju'])->result();
    $data['pending_documents'] = $this->db->get_where('document', ['document_status' => 'pending'])->result();
    $data['reject_documents'] = $this->db->get_where('document', ['document_status' => 'tolak'])->result();
    view('staff/list-doc', $data);
  }

  public function upload_doc() {
    $data['title'] = 'Upload Dokumen';
    view('staff/upload-doc', $data);

    if (isset($_POST['submit'])) {


      //DEKLARASI VARIABLES
      $name = htmlspecialchars($this->input->post('doc_name'), true);
      $doc_name = str_replace(' ', '_', $name);
      $image = $_FILES['doc_file']['name'];
      $extension = pathinfo($_FILES['doc_file']['name'], PATHINFO_EXTENSION);

      // KETIKA GAMBR ADA YANG AKAN DIUPLOAD
      if (!empty($image)) {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'doc|docx|pdf|xls|xlsx';
        $config['max_size'] = '10048';
        $config['file_name'] = "{$doc_name}_".time().".{$extension}";
        $this->load->library('upload', $config);
        // KETIKA GAMBAR BERHASIL DIUPLOAD
        if ($this->upload->do_upload('doc_file')) {
          $data_doc = [
            'document_file' => $config['file_name'],
            'document_name' => $name,
            'document_status' => 'pending',
            'created_at' => date('Y-m-d H:i:s')
          ];
          $this->db->insert('document', $data_doc);

          $this->session->set_flashdata('success', 'dokumen berhasil diupload');
          return ke('staff/list_doc');
        } else {
          // KETIKA GAMBAR TIDAK LOLOS VALIDASI
          echo   $image_error = $this->upload->display_errors();

          die;
        }
      } else {
        //KETIKA GAMBAR TIDAK ADA YANG DIUPLOAD
        echo 'belum ke upload';
      }

    }

  }
}