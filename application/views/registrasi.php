

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg col-lg-6 my-5 mx-auto">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg">
                        <div class="p-5 text-center">
                            <h1 class="h4 text-gray-900 mb-4">Daftar Akun!</h1>
                            <form method="post" action="<?php echo base_url('registrasi/index') ?>" class="user">
                                <!-- div class="form-group">
                                    <input type="text" class="form-control form-control-user" placeholder="Nama Anda" name="nama">
                                    <?php echo form_error('nama', '<div class="badge badge-danger">','</div>') ?>
                                </div> -->
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" placeholder="Username Anda" name="username">
                                    <?php echo form_error('username', '<div class="badge badge-danger">','</div>') ?>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user" name="password_1" placeholder="Password">
                                        <?php echo form_error('password_1', '<div class="badge badge-danger">','</div>') ?>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control form-control-user" name="password_2" placeholder="Ulangi Password">
                                        <?php echo form_error('password_2', '<div class="badge badge-danger">','</div>') ?>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">Daftar</button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="<?php echo base_url('auth/login') ?>">Sudah Punya Akun? Silahkan Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>