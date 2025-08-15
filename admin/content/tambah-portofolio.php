    <?php
    $id = isset($_GET['edit']) ? $_GET['edit'] : '';

    if (isset($_GET['edit'])) {
        $id = $_GET['edit'];
        $query = mysqli_query($koneksi, "SELECT * FROM portofolio WHERE id = '$id'");
        $rowEdit = mysqli_fetch_assoc($query);

        $title = "Edit Portofolio";
    } else {
        $title = "Tambah Portofolio";
    }

    if (isset($_POST['simpan'])) {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $is_active = $_POST['is_active'];
        $id_category = $_POST['id_category'];
        $client_name = $_POST['client_name'];
        $project_date = $_POST['project_date'];
        $project_url = $_POST['project_url'];



        // buat narik gambar dari upload file
        if (!empty($_FILES['image']['name'])) {      #$_FILE ini buat ngolah file dari form type file, dan ini buat cek file foto nya udah ke up apa blom ()
            $image = $_FILES['image']['name'];
            $tmp_name = $_FILES['image']['tmp_name'];

            # FIle type checking
            $type = mime_content_type($tmp_name);
            $allowed_filetype = ['image/jpg', 'image/png', 'image/jpeg'];

            if (in_array($type, $allowed_filetype)) {
                #boleh upload
                $path = "uploads/portofolio/";     # ini buat nyimpen file gambar ke folder mana (di db)
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
            // ini buat edit portofolio klo ada gambar
            $update_image = "UPDATE portofolio SET title='$title', content='$content', image='$image_name', is_active='$is_active', client_name='$client_name', id_category='$id_category', project_date='$project_date', project_url='$project_url' WHERE id='$id'";
        } else {
            // ini buat edit portofolio klo gak ada gambar
            $update_image = "UPDATE portofolio SET title='$title', content='$content', is_active='$is_active', client_name='$client_name', id_category='$id_category', project_date='$project_date', project_url='$project_url' WHERE id='$id'";
        }


        if ($id) {
            // disini edit portofolio
            $insert = mysqli_query($koneksi, $update_image);
            if ($insert) {
                header("location:?page=portofolio&ubah=berhasil");
            }
        } else {
            // disini tambah portofolio
            $insert = mysqli_query($koneksi, "INSERT INTO portofolio (title, content, image, is_active, client_name, id_category, project_date, project_url) VALUES ('$title','$content','$image_name','$is_active','$client_name','$id_category', '$project_date', '$project_url')");
            if ($insert) {
                header("location:?page=portofolio&tambah=berhasil");
            }
        }
    }

    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];
        $queryGambar = mysqli_query($koneksi, "SELECT id, image FROM portofolio WHERE id='$id'");
        $rowGambar = mysqli_fetch_assoc($queryGambar);

        $image_name = $rowGambar['image'];
        unlink("uploads/portofolio/" . $image_name);

        $delete = mysqli_query($koneksi, "DELETE FROM portofolio WHERE id='$id'");
        if ($delete) {
            header("location:?page=portofolio&hapus=berhasil");
        }
    }

    $queryCategory = mysqli_query($koneksi, "SELECT * FROM categories WHERE type='portofolio' ORDER BY id DESC");
    $rowCategory = mysqli_fetch_all($queryCategory, MYSQLI_ASSOC);
    ?>

    <div class="pagetitle">
        <h1><?php echo $title; ?></h1>
    </div><!-- End Page Title -->

    <section class="section">

        <form action="" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $title; ?></h5>
                            <!-- kalo mau ada inputan file tambahin enctype="multipart/form-data" -->
                            <label for="" class="form-label">Kategori</label>
                            <select name="id_category" class="form-control">
                                <option value="">Pilih Kategori</option>
                                <?php foreach ($rowCategory as $key => $categories) : ?>
                                    <option value="<?php echo $categories['id'] ?>"><?php echo $categories['name'] ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="" class="form-label">Project Name</label>
                            <input type="text" name="title" class="form-control" required value="<?php echo ($id) ? $rowEdit['title'] : '' ?>">
                            <label for="" class="form-label">Client Name</label>
                            <input type="text" name="client_name" class="form-control" required value="<?php echo ($id) ? $rowEdit['client_name'] : '' ?>">
                            <label for="" class="form-label">Project Date</label>
                            <input type="date" name="project_date" class="form-control" required value="<?php echo ($id) ? $rowEdit['project_date'] : '' ?>">
                            <label for="" class="form-label">Project Link</label>
                            <input type="url" name="project_url" class="form-control" required value="<?php echo ($id) ? $rowEdit['project_url'] : '' ?>">
                            <label for="" class="form-label">Image</label>
                            <input type="file" name="image" class="form-control">
                            <!-- dibawah ini cara make summernote (cek <script> home.php buat konteks)  -->
                            <label for="" class="form-label">Content</label>
                            <textarea name="content" class="form-control" required><?php echo ($id) ? $rowEdit['content'] : '' ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card p-3">
                        <div class="card-body">
                            <label for="">Publish / Draft</label>
                            <select name="is_active" id="" class="form-control">
                                <option <?php echo ($id) ? $rowEdit['is_active'] == 1 ? 'selected' : '' : '' ?> value="1">Publish</option>
                                <option <?php echo ($id) ? $rowEdit['is_active'] == 0 ? 'selected' : '' : '' ?> value="0">Draft</option>
                            </select>
                            <div class="my-3 d-flex gap-2">
                                <button class="btn btn-outline-primary" type="submit" name="simpan">Simpan</button>
                                <button class="btn btn-outline-success" href="?page=portofolio">Kembali</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>