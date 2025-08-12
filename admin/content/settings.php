<?php 
    # jika data settings sdh ada maka update data tersebut
    # selain itu klo blom ada maka

    if (isset($_POST['simpan'])) {
        $email = $_POST['email'];
        $phone= $_POST['phone'];
        $address = $_POST['address'];
        $fb = $_POST['fb'];
        $ig = $_POST['ig'];
        $twitter = $_POST['twitter'];
        $linkedin = $_POST['linkedin'];
        $querySetting = mysqli_query($koneksi, "SELECT * FROM settings LIMIT 1"); // LIMIT buat ngebatasin berapa banyak data yg di query / fetch dari db, misal LIMIT 3 ya dia fetch 3 data aj dari keseluruhan tabel gak kya sebelumnya yg tanpa limit
        
        if (mysqli_num_rows($querySetting)  > 0) {
            # update
            
            $id_settings = $row['id']; // $row['nama_kolom_yg_mw_diambil'] ini buat ambil value dari satu kolom dari row, nahh biasanya ini buat ngambil id
            $update = mysqli_query($koneksi, "UPDATE settings SET email='$email', phone='$phone', address='$address', fb='$fb', ig='$ig', twitter='$twitter', linkedin='$linkedin' WHERE id='$id_settings'");

            if($update){
                header("location:?page=settings&ubah=berhasil");
            }
        } else {
            # insert data settings
            $insert = mysqli_query($koneksi, "INSERT INTO settings (email, phone, address, fb, ig, twitter, linkedin) VALUES ('$email','$phone','$address','$fb','$ig','$twitter','$linkedin')");
            if($insert){
                header("location:?page=settings&tambah=berhasil");
            }
        }
        
    }

    $querySetting = mysqli_query($koneksi, "SELECT * FROM settings LIMIT 1");   #ini diulang lg diluar if supaya bisa nampilin data2 nya ke form
    $row = mysqli_fetch_assoc($querySetting);

?>

<div class="pagetitle">
    <h1>Pengaturan</h1>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Pengaturan</h5>
                    <form action="" method="post" enctype="multipart/form-data">
                    <div class=" row">
                        <div class="mb-3 w-50">
                            <label for="" class="form-label fw-bold">Email</label>
                            <input type="email" name="email" id="" class="form-control" value="<?php echo (isset($row['email'])) ? $row['email'] : '' ?>">
                        </div>
                        <div class="mb-3 w-50">
                            <label for="" class="form-label fw-bold">No. Telp</label>
                            <input type="number" name="phone" id="" class="form-control" value="<?php echo (isset($row['phone'])) ? $row['phone'] : '' ?>">
                        </div>
                        <div class="mb-3 w-50">
                            <label for="" class="form-label fw-bold">Alamat</label>
                            <input type="textarea" name="address" id="" class="form-control" value="<?php echo (isset($row['address'])) ? $row['address'] : '' ?>">
                        </div>
                        <div class="mb-3 w-50">
                            <label for="" class="form-label fw-bold">Logo</label>
                            <input type="file" name="logo" id="" class="form-control">
                        </div>
                        <div class="mb-3 w-50">
                            <label for="fb" class="form-label fw-bold">Facebook</label>
                            <input type="url" name="fb" id="" class="form-control" value="<?php echo (isset($row['fb'])) ? $row['fb'] : '' ?>">
                        </div>
                        <div class="mb-3 w-50">
                            <label for="twitter" class="form-label fw-bold">Twitter</label>
                            <input type="url" name="twitter" id="" class="form-control" value="<?php echo (isset($row['twitter'])) ? $row['twitter'] : '' ?>">
                        </div>
                        <div class="mb-3 w-50">
                            <label for="linkedin" class="form-label fw-bold">Likedin</label>
                            <input type="url" name="linkedin" id="" class="form-control" value="<?php echo (isset($row['linkedin'])) ? $row['linkedin'] : '' ?>">
                        </div>
                        <div class="mb-3 w-50">
                            <label for="ig" class="form-label fw-bold">Instagram</label>
                            <input type="url" name="ig" id="" class="form-control" value="<?php echo (isset($row['ig'])) ? $row['ig'] : '' ?>">
                        </div>
                        <button class="btn btn-outline-primary" name="simpan">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    </div>


    </div>
</section>