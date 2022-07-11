<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Seleksiotomatis extends MY_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Laporan_model','laporan');
        $this->load->model('Prodi_model','prodi');
        $this->load->model('Seleksimanual_model','seleksimanual');
    }
 
    public function index()
    {
        $data=array(
            'tahunakademik' => $this->pengaturan->gettahunakademik()->nilai,
            'view' => 'seleksiotomatis/seleksiotomatis_view',
        );
        $this->load->view('layout',$data);
    }
    public function tes()
    {
        $this->load->helper('seleksi_otomatis');
        echo do_otomatis();
        //$this->load->view('layout',array('view'=>'seleksiotomatis/result_otomatis'));
    }
    public function do_otomatis()
    {      
        $data = $this->get_prodi();
        echo '<strong>Terima di Pilihan 1</strong> <br><br>';
        foreach($data as $datares){
            $limit1 = $datares->dayatampung;
            $data1 = $this->get_pilihan1_sort_by_nilai($datares->namaprodi,$limit1);
            $no = 1;
            $dayatampung1 = $datares->dayatampung;
            $peminat1 = count($data1);
            $terima1 = $peminat1 <= $dayatampung1 ? $peminat1 : $dayatampung1;
            $sisa1 = $dayatampung1-$terima1;
            echo '<strong>Pilihan 1 : '.ucwords(strtolower($datares->namaprodi)).' (Daya tampung : '.$dayatampung1.', Peminat P1 : '.$peminat1.', Terima : '.$terima1.', Sisa daya tampung: '.$sisa1.')</strong><br>';
            foreach ($data1 as $data1res) {
                $data1resarray = array(
                    'nopendaftar' => $data1res->nopendaftar,
                    'idprodi' => $this->prodi->get_by_prodiname($data1res->pilihan1)->idprodi,
                );
                $this->db->insert('penerimaan', $data1resarray);
                echo $no++.'. '.$data1res->namapendaftar.' | '.$data1res->nopendaftar.' | '.$data1res->ratarata.'<br>';
            }
            echo '<br>';
        }

        echo '<br><strong>Terima di Pilihan 2 </strong><br><br>';
        foreach($data as $datares){
            $limit1 = $datares->dayatampung;
            $data1 = $this->get_pilihan1_sort_by_nilai($datares->namaprodi,$limit1);
            $dayatampung1 = $datares->dayatampung;
            $peminat1 = count($data1);
            $terima1 = $peminat1 <= $dayatampung1 ? $peminat1 : $dayatampung1;
            $sisa1 = $dayatampung1-$terima1;

            $limit2 = $datares->dayatampung-$this->get_sisa_kuota_prodi($datares->namaprodi);
            $data2 = $this->get_pilihan2_sort_by_nilai($datares->namaprodi,$limit2);
            $no = 1;
            $dayatampung2 = $datares->dayatampung-$this->get_sisa_kuota_prodi($datares->namaprodi);
            $dayatampung2 = $sisa1;
            $peminat2 = count($data2);
            $terima2 = $peminat2 <= $dayatampung2 ? $peminat2 : $dayatampung2;
            $sisa2 = $dayatampung2-$terima2;
            echo '<strong>Pilihan 2 : '.ucwords(strtolower($datares->namaprodi)).' (Sisa daya tampung dari seleksi pilihan 1 : '.$dayatampung2.', Peminat P2 : '.$peminat2.', Terima : '.$terima2.', Sisa Daya Tampung: '.$sisa2.')</strong><br>';
            foreach ($data2 as $data2res) {
                $data2resarray = array(
                    'nopendaftar' => $data2res->nopendaftar,
                    'idprodi' => $this->prodi->get_by_prodiname($data2res->pilihan2)->idprodi,
                );
                $this->db->insert('penerimaan', $data2resarray);
                echo $no++.'. '.$data2res->namapendaftar.' | '.$data2res->nopendaftar.' | '.$data2res->ratarata.'<br>';
            }
            echo '<br>';
        } 

        echo '<br><strong>Terima di Pilihan 3 </strong><br><br>';
        foreach($data as $datares){
            $limit1 = $datares->dayatampung;
            $data1 = $this->get_pilihan1_sort_by_nilai($datares->namaprodi,$limit1);
            $dayatampung1 = $datares->dayatampung;
            $peminat1 = count($data1);
            $terima1 = $peminat1 <= $dayatampung1 ? $peminat1 : $dayatampung1;
            $sisa1 = $dayatampung1-$terima1;
            
            $limit2 = $datares->dayatampung-$this->get_sisa_kuota_prodi($datares->namaprodi);;
            $data2 = $this->get_pilihan2_sort_by_nilai($datares->namaprodi,$limit2);
            $dayatampung2 = $datares->dayatampung-$this->get_sisa_kuota_prodi($datares->namaprodi);;
            $peminat2 = count($data2);
            $terima2 = $peminat2 <= $dayatampung2 ? $peminat2 : $dayatampung2;
            $sisa2 = $dayatampung2-$terima2;

            $limit3 = $datares->dayatampung-$this->get_sisa_kuota_prodi($datares->namaprodi);
            $data3 = $this->get_pilihan3_sort_by_nilai($datares->namaprodi,$limit3);
            $no = 1;
           
            $dayatampung3 = $datares->dayatampung-$this->get_sisa_kuota_prodi($datares->namaprodi);
            $dayatampung3 = $sisa2;
            $peminat3 = count($data3);
            $terima3 = $peminat3 <= $dayatampung3 ? $peminat3 : $dayatampung3;
            $sisa3 = $dayatampung3-$terima1-$terima3;
            echo '<strong>Pilihan 3 : '.ucwords(strtolower($datares->namaprodi)).' (Sisa daya tampung dari seleksi pilihan 1 dan pilihan 2 : '.$dayatampung3.', Peminat P3: '.$peminat3.', Terima : '.$terima3.', Sisa daya tampung : '.$sisa3.')</strong><br>';
            foreach ($data3 as $data3res) {
                $data3resarray = array(
                    'nopendaftar' => $data3res->nopendaftar,
                    'idprodi' => $this->prodi->get_by_prodiname($data3res->pilihan3)->idprodi,
                );
                $this->db->insert('penerimaan', $data3resarray);
                echo $no++.'. '.$data3res->namapendaftar.' | '.$data3res->nopendaftar.' | '.$data3res->ratarata.'<br>';
            }
            echo '<br>';
        } 
    }
    
    private function get_sisa_kuota_prodi($prodi)
    {
        $this->db->select('*');
        $this->db->from('v_penerimaan');
        $this->db->where('namaprodi',$prodi);
        $query = $this->db->get();
        return $query->num_rows();
    }


    private function get_pilihan1_sort_by_nilai($prodi,$limit)
    {
        $this->db->select('nopendaftar, namapendaftar, pilihan1, ratarata');
        $this->db->from('v_seleksi');
        $this->db->where('pilihan1',$prodi);
        $this->db->where('status','B');
        $this->db->where('tahunlulus >',date('Y')-4);
        $this->db->order_by('ratarata', 'desc');
        $this->db->limit($limit);
        $data1 = $this->db->get();
        return $data1->result();
        
    }

    private function get_pilihan2_sort_by_nilai($prodi,$limit)
    {
        $this->db->select('nopendaftar, namapendaftar, pilihan2, ratarata');
        $this->db->from('v_seleksi');
        $this->db->where('pilihan2',$prodi);
        $this->db->where('status','B');
        $this->db->where('tahunlulus >',date('Y')-4);
        $this->db->order_by('ratarata', 'desc');
        $this->db->limit($limit);
        $data2 = $this->db->get();
        return $data2->result();
        
    }

    private function get_pilihan3_sort_by_nilai($prodi,$limit)
    {
        $this->db->select('nopendaftar, namapendaftar, pilihan3, ratarata');
        $this->db->from('v_seleksi');
        $this->db->where('pilihan3',$prodi);
        $this->db->where('status','B');
        $this->db->where('tahunlulus >',date('Y')-4);
        $this->db->order_by('ratarata', 'desc');
        $this->db->limit($limit);
        $data3 = $this->db->get();
        return $data3->result();
        
    }

    private function get_prodi()
    {
        $this->db->select('idprodi, namaprodi, dayatampung');
        $query = $this->db->get('prodi');
        return $query->result();

    }

}