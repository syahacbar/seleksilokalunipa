<div class="box"> 
    <div class="box-header">
        <h3 class="box-title">Seleksi Calon Mahasiswa Baru Universitas Papua Jalur Seleksi Lokal TA. <?=$tahunakademik;?></h3>  
   </div>
   <div class="box-body table-responsive">
        <p>Seleksi otomatis merupakan fitur untuk melakukan seleksi secara kolektif berdasarkan pilihan prodi, jumlah peminatan, daya tampung, dan nilai rata-rata pendaftar.<br>
        Jika anda yakin akan melakukan proses seleksi secara otomatis, tekan tombol berikut</p>
        <!--<button id="btnterimaotomatis" class="btn btn-sm btn-success" onclick="terima_otomatis()">Terima Otomatis</button>
        -->
        <a class="btn btn-sm btn-success" target="blank" href="<?php echo base_url('seleksiotomatis/do_otomatis')?>">Terima Otomatis</a>
   </div>
    <div class="resultdiv">
    </div>


<script type="text/javascript">
    function terima_otomatis(){
        var vo = document.getElementById('view_otomatis');
        $.ajax({
            type: "POST",
            url : "<?php echo base_url('seleksiotomatis/do_otomatis')?>",
            dataType: "JSON",
            success: function(data)
            {
                $('#resultdiv').html(data);
            },
        });
    }
</script>