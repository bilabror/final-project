<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Controller Laporan
*
* @author	Pertiwi Team
* @copyright	Copyright (c) 2021
*/
class Laporan extends CI_Controller {

  /**
  * Prefix url controller ini
  *
  * @var	string
  */
  private $prefix = 'superadmin/laporan';

  /**
  * Class constructor
  * Akan selalu dijalankan ketika masuk pada controller ini
  *
  * @return	void
  */
  public function __construct() {
    parent::__Construct();
    isLogin();
    isSupervisor();
    model('Jabatan_model', 'jabatan');
    model('Pangkat_model', 'pangkat');
    model('Laporan_model', 'laporan');
    model('Superadmin_model', 'superadmin');
  }

  /**
  * Method Index
  * Halaman untuk mengelola data laporan
  * Data parsing : judul halaman, semua data laporan
  *
  * @return view
  */
  public function index() {
    $this->db->order_by('tgl_upload', 'desc');
    $this->db->where('status', 2);
    $data['laporan'] = $this->laporan->getAll();
    $data['jabatan'] = $this->jabatan->getAll();
    $data['pangkat'] = $this->pangkat->getAll();
    $data['title'] = 'List Data laporan';
    view('supervisor/list-laporan', $data);
  }



}