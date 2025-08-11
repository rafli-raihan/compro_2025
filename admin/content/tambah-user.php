    <?php
        if (isset($_POST['simpan'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            $insert = mysqli_query($koneksi, "INSERT INTO users (name, email, password) VALUES ('$name','$email','$password')");
            if($insert){
                header("location:?page=user&tambah=berhasil");
            }
        }

        $query = mysqli_query($koneksi, "SELECT * FROM users ORDER BY id DESC");
        $rows = mysqli_fetch_all($query, MYSQLI_ASSOC);
    ?>
    
    <div class="pagetitle">
        <h1>Tambah User</h1>
    </div><!-- End Page Title -->

    <section class="section">

        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Tambah User</h5>
                        <form action="" method="post">
                            <label for="">Nama</label>
                            <input type="text" name="name" class="form-control" required>
                            <label for="">Email</label>
                            <input type="email" name="email" class="form-control" required>
                            <label for="">Password</label>
                            <input type="password" name="password" class="form-control" required>
                            <div class="my-3">
                                <button class="btn btn-outline-primary" type="submit" name="simpan">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
