    <?php
    $id = isset($_GET['edit']) ? $_GET['edit'] : '';

    if (isset($_GET['edit'])) {
        $id = $_GET['edit'];
        $query = mysqli_query($koneksi, "SELECT * FROM slider WHERE id = '$id'");
        $rowEdit = mysqli_fetch_assoc($query);

        $title = "Edit User";
    } else {
        $title = "Tambah User";
    }

    if (isset($_POST['simpan'])) {
        $title = $_POST['title'];
        $description = $_POST['description'];
        //buat narik gambar dari upload file
        if (!empty($_FILES['image']['name'])) {      #$_FILE ini buat ngolah file dari form type file
            $image = $_FILES['image']['name'];
            $tmp_name = $_FILES['image']['tmp_name'];

            # FIle type checking
            $type = mime_content_type($tmp_name);
            $allowed_filetype = ['image/jpg', 'image/png', 'image/jpeg'];

            if (in_array($type, $allowed_filetype)) {
                #boleh upload
                $path = "uploads/";     # ini buat nyimpen file gambar ke folder mana (di db)
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
            // disini edit slider
            $insert = mysqli_query($koneksi, "UPDATE slider SET title='$title', description='$description', image='$image_name' WHERE id='$id'");
            if ($insert) {
                header("location:?page=slider&ubah=berhasil");
            }
        } else {
            // disini tambah slider
            $insert = mysqli_query($koneksi, "INSERT INTO slider (title, description, image) VALUES ('$title','$description','$image_name')");
            if ($insert) {
                header("location:?page=slider&tambah=berhasil");
            }
        }
    }
    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];
        $queryGambar = mysqli_query($koneksi, "SELECT id, image FROM slider WHERE id='$id'");
        $rowGambar = mysqli_fetch_assoc($queryGambar);

        $image_name = $rowGambar['image'];
        unlink('uploads/' . $image_name);

        $delete = mysqli_query($koneksi, "DELETE FROM slider WHERE id='$id'");
        if ($delete) {
            header("location:?page=slider&hapus=berhasil");
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
                        <!-- kalo mau ada inputan file tambahin enctype="multipart/form-data" -->
                        <form action="" method="post" enctype="multipart/form-data">
                            <label for="">Title</label>
                            <input type="text" name="title" class="form-control" required value="<?php echo ($id) ? $rowEdit['name'] : '' ?>">
                            <label for="">Description</label>
                            <input type="textarea" name="description" class="form-control" required value="<?php echo ($id) ? $rowEdit['email'] : '' ?>">
                            <label for="">Image</label>
                            <input type="file" name="image" class="form-control">
                            <div class="my-3 d-flex">
                                <button class="btn btn-outline-primary" type="submit" name="simpan">Simpan</button>
                            </div>
                        </form>
                        <button class="btn btn-outline-success" href="?page=slider">Kembali</button>
                    </div>
                </div>
            </div>
        </div>
    </section>