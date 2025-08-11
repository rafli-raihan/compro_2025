    <?php
        $id = isset($_GET['edit']) ? $_GET['edit'] : '';

        if (isset($_GET['edit'])) {
            $id = $_GET['edit'];
            $query = mysqli_query($koneksi, "SELECT * FROM users WHERE id = '$id'");
            $rowEdit = mysqli_fetch_assoc($query);

            $title = "Edit User";
        }else{
            $title = "Tambah User";
        }

        if (isset($_POST['simpan'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = ($_POST['password']) ? $_POST['password'] : $rowEdit['password'];

            if($id){
                // disini edit user
                $insert = mysqli_query($koneksi, "UPDATE users SET name='$name', email='$email', password='$password' WHERE id='$id'"); 
                if($insert){
                    header("location:?page=user&ubah=berhasil");
                }
            }else{
                // disini tambah user
                $insert = mysqli_query($koneksi, "INSERT INTO users (name, email, password) VALUES ('$name','$email','$password')");
                if($insert){
                    header("location:?page=user&tambah=berhasil");
                }
            }
        }
        if (isset($_GET['delete'])) {
            $id = $_GET['delete'];
            $delete = mysqli_query($koneksi, "DELETE FROM users WHERE id='$id'");

            if ($delete) {
                header("location:?page=user&hapus=berhasil");
            }
        }
    ?>
    
    <div class="pagetitle">
        <h1><?php echo $title; ?></h1>
    </div><!-- End Page Title -->

    <section class="section">

        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $title; ?></h5>
                        <form action="" method="post">
                            <label for="">Nama</label>
                            <input type="text" name="name" class="form-control" required value="<?php echo ($id) ? $rowEdit['name'] : '' ?>">
                            <label for="">Email</label>
                            <input type="email" name="email" class="form-control" required  value="<?php echo ($id) ? $rowEdit['email'] : '' ?>">
                            <label for="">Password</label>
                            <input type="password" name="password" class="form-control" <?php echo (!$id) ? 'required' : ''; ?>>
                            <small>* isi password jika ingin merubah password</small>
                            <div class="">
                                <button class="btn btn-outline-primary" type="submit" name="simpan">Simpan</button>
                            </div>
                        </form>
                        <button class="btn btn-outline-success" type="kembali" name="simpan" href="?page=user">Kembali</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
