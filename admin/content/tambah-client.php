    <?php
    $id = isset($_GET['edit']) ? $_GET['edit'] : '';

    if (isset($_GET['edit'])) {
        $id = $_GET['edit'];
        $query = mysqli_query($koneksi, "SELECT * FROM client WHERE id = '$id'");
        $rowEdit = mysqli_fetch_assoc($query);

        $name = "Edit Client";
    } else {
        $name = "Tambah Client";
    }

    if (isset($_POST['simpan'])) {
        $name = $_POST['name'];
        $is_active = $_POST['is_active'];
        //buat narik gambar dari upload file
        if (!empty($_FILES['image']['name'])) {      #$_FILE ini buat ngolah file dari form type file
            $image = $_FILES['image']['name'];
            $tmp_name = $_FILES['image']['tmp_name'];

            # FIle type checking
            $type = mime_content_type($tmp_name);
            $allowed_filetype = ['image/jpg', 'image/png', 'image/jpeg'];

            if (in_array($type, $allowed_filetype)) {
                #boleh upload
                $path = "uploads/client/";     # ini buat nyimpen file gambar ke folder mana (di db)
                if (!is_dir($path)) {   # kalo folder uploads blom ada (di db), dia buat foldernya
                    mkdir($path);
                }

                $image_name = time() . "-" . basename($image);   #ini buat hashing (enkripsi) gambar pake waktu
                $target_file = $path . $image_name;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                    # Jika gambarnya ada, maka gambar sebelumnya di replace sm yg baru (logo lama diapus ditimpa yg baru)
                    if (!empty($row['image'])) {
                        # ini buat cek file logo di uploads udah ada isinya blom, klo udah ada dihapus ditimpa pake yg baru
                        unlink($path . $row['image']);
                    }
                }
            } else {
                echo "tidak boleh upload";
                die;
            }
        }


        if ($id) {
            // disini edit client
            $insert = mysqli_query($koneksi, "UPDATE client SET name='$name', image='$image_name', is_active='$is_active' WHERE id='$id'");
            if ($insert) {
                header("location:?page=client&ubah=berhasil");
            }
        } else {
            // disini tambah client
            $insert = mysqli_query($koneksi, "INSERT INTO client (name, image, is_active) VALUES ('$name','$image_name','$is_active')");
            if ($insert) {
                header("location:?page=client&tambah=berhasil");
            }
        }
    }
    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];
        $queryGambar = mysqli_query($koneksi, "SELECT id, image FROM client WHERE id='$id'");
        $rowGambar = mysqli_fetch_assoc($queryGambar);

        $image_name = $rowGambar['image'];
        unlink("uploads/client/" . $image_name);

        $delete = mysqli_query($koneksi, "DELETE FROM client WHERE id='$id'");
        if ($delete) {
            header("location:?page=client&hapus=berhasil");
        }
    }
    ?>

    <div class="pagetitle">
        <h1><?php echo $name; ?></h1>
    </div><!-- End Page Title -->

    <section class="section">

        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-name"><?php echo $name; ?></h5>
                        <!-- kalo mau ada inputan file tambahin enctype="multipart/form-data" -->
                        <form action="" method="post" enctype="multipart/form-data">
                            <label for="">Name</label>
                            <input type="text" name="name" class="form-control" required value="<?php echo ($id) ? $rowEdit['name'] : '' ?>">
                            <label for="">Content</label>
                            <!-- dibawah ini cara make summernote (cek <script> home.php buat konteks)  -->
                            <label for="">Publish / Draft</label>
                            <select name="is_active" id="" class="form-control">
                                <option <?php echo ($id) ? $rowEdit['is_active'] == 1 ? 'selected' : '' : '' ?> value="1">Publish</option>
                                <option <?php echo ($id) ? $rowEdit['is_active'] == 0 ? 'selected' : '' : '' ?> value="0">Draft</option>
                            </select>
                            <label for="">Image</label>
                            <input type="file" name="image" class="form-control">
                            <div class="my-3 d-flex">
                                <button class="btn btn-outline-primary" type="submit" name="simpan">Simpan</button>
                            </div>
                        </form>
                        <button class="btn btn-outline-success" href="?page=client">Kembali</button>
                    </div>
                </div>
            </div>
        </div>
    </section>