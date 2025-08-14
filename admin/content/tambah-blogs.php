    <?php
    $id = isset($_GET['edit']) ? $_GET['edit'] : '';

    if (isset($_GET['edit'])) {
        $id = $_GET['edit'];
        $query = mysqli_query($koneksi, "SELECT * FROM blogs WHERE id = '$id'");
        $rowEdit = mysqli_fetch_assoc($query);

        $title = "Edit Blogs";
    } else {
        $title = "Tambah Blogs";
    }

    if (isset($_POST['simpan'])) {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $is_active = $_POST['is_active'];
        $penulis = $_SESSION['NAME']; # Ini jadi ngambil username akun yg ke login di admin bwt jd penulis
        $id_category = $_POST['id_category'];
        $tags = $_POST['tags'];

        // buat narik gambar dari upload file
        if (!empty($_FILES['image']['name'])) {      #$_FILE ini buat ngolah file dari form type file, dan ini buat cek file foto nya udah ke up apa blom ()
            $image = $_FILES['image']['name'];
            $tmp_name = $_FILES['image']['tmp_name'];

            # FIle type checking
            $type = mime_content_type($tmp_name);
            $allowed_filetype = ['image/jpg', 'image/png', 'image/jpeg'];

            if (in_array($type, $allowed_filetype)) {
                #boleh upload
                $path = "uploads/blogs/";     # ini buat nyimpen file gambar ke folder mana (di db)
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
            // ini buat edit blog klo ada gambar
            $update_image = "UPDATE blogs SET title='$title', content='$content', image='$image_name', is_active='$is_active', penulis='$penulis', id_category='$id_category', tags='$tags' WHERE id='$id'";
        } else {
            // ini buat edit blog klo gak ada gambar
            $update_image = "UPDATE blogs SET title='$title', content='$content', is_active='$is_active', penulis='$penulis', id_category='$id_category', tags='$tags' WHERE id='$id'";
        }


        if ($id) {
            // disini edit blogs
            $insert = mysqli_query($koneksi, $update_image);
            if ($insert) {
                header("location:?page=blog&ubah=berhasil");
            }
        } else {
            // disini tambah blogs
            $insert = mysqli_query($koneksi, "INSERT INTO blogs (title, content, image, is_active, penulis, id_category, tags) VALUES ('$title','$content','$image_name','$is_active','$penulis','$id_category','$tags')");
            if ($insert) {
                header("location:?page=blog&tambah=berhasil");
            }
        }
    }

    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];
        $queryGambar = mysqli_query($koneksi, "SELECT id, image FROM blogs WHERE id='$id'");
        $rowGambar = mysqli_fetch_assoc($queryGambar);

        $image_name = $rowGambar['image'];
        unlink("uploads/blogs/" . $image_name);

        $delete = mysqli_query($koneksi, "DELETE FROM blogs WHERE id='$id'");
        if ($delete) {
            header("location:?page=blog&hapus=berhasil");
        }
    }

    $queryCategory = mysqli_query($koneksi, "SELECT * FROM categories ORDER BY id DESC");
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
                            <label for="" class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" required value="<?php echo ($id) ? $rowEdit['title'] : '' ?>">
                            <label for="" class="form-label">Tags</label>
                            <input type="text" id="tags" name="tags" class="form-control" required value="<?php echo ($id && !empty($rowEdit['$tags'])) ? json_encode(json_decode($rowEdit['tags'])) : '' ?>">
                            <label for="" class="form-label">Image</label>
                            <input type="file" name="image" class="form-control">
                            <!-- dibawah ini cara make summernote (cek <script> home.php buat konteks)  -->
                            <label for="" class="form-label">Content</label>
                            <textarea name="content" id="summernote" class="form-control" required><?php echo ($id) ? $rowEdit['content'] : '' ?></textarea>
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
                                <button class="btn btn-outline-success" href="?page=blogs">Kembali</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>