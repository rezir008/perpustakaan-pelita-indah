<div class="container-fluid">
	<div class="row">
		<div class="col p-1">
            <div class="card bg-primary h-100">
                <div class="card-body text-white">
                    <div class="row no-gutters align-items-center">
                        <div class="col">
                            <a href="<?php echo base_url('dashboard_petugas/daftar_buku')?>" class="text-white">
                            	<div class="badge text-uppercase">Jumlah Buku :</div>
	                            <h3 class="font-weight-bold my-1"> <?php echo count($buku) ?> </h3>
                            </a>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div><div class="col p-1">
            <div class="card bg-primary h-100">
                <div class="card-body text-white">
                    <div class="row no-gutters align-items-center">
                        <div class="col">
                            <?php
                                $jmlh_terpinjam = 0;
                                foreach ($peminjaman_buku as $terpinjam) : 
                                    $jmlh_terpinjam += $terpinjam->jumlah;
                                endforeach;
                            ?> 
                             <a href="<?php echo base_url('dashboard_petugas/riwayat_peminjaman/'.'0')?>" class="text-white">
                                <div class="badge text-uppercase">Jumlah Buku Terpinjam:</div>
                                <h3 class="font-weight-bold my-1"> <?php echo $jmlh_terpinjam ?> </h3>
                            </a>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
	<div class="row">
		<div class="col p-1">
            <div class="card border-left-primary h-100">
                <div class="card-body">
                    <div class="dropdown">
                      <button class="btn btn-sm btn-warning dropdown-toggle float-left" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-bookmark"></i> Peminjaman
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                        <a class="dropdown-item text-wrap" href="<?php echo base_url('dashboard_petugas/peminjaman'); ?>"> 
                            <span>Peminjaman Baru</span>
                            <?php $keranjang = $this->cart->total_items(); ?>
                            <div class="badge badge-info"><?php if($this->cart->contents()){ echo $keranjang; }?></div>
                        </a>
                        <a class="dropdown-item text-wrap" href="<?php echo base_url('dashboard_petugas/riwayat_peminjaman/'.'0')?>">Riwayat Peminjaman</a>
                      </div>
                    </div>

                    
                </div>
            </div>
        </div><div class="col p-1">
            <div class="card border-left-primary h-100">
                <div class="card-body">
                    <a class="btn btn-sm btn-success" 
                        href="<?php echo base_url('dashboard_petugas/pengembalian/'.'0')?>">
            			<i class="fas fa-bookmark"></i> Pengembalian
                    </a>
                </div>
            </div>
        </div>
	</div>
</div>