<?php
$query = mysqli_query($koneksi, "SELECT * FROM client ORDER BY id DESC");
$rows = mysqli_fetch_all($query, MYSQLI_ASSOC);
?>

<div class="pagetitle">
    <h1>Client Content</h1>
</div><!-- End Page Title -->

<section class="section">

    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-name">Client Content</h5>

                    <div class="mb-3" align="right">
                        <a href="?page=tambah-client" class="btn btn-primary">Tambah</a>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Logo</th>
                                <th>Nama</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($rows as $key => $row): ?>
                                <tr>
                                    <td><?php echo $key += 1; ?></td>
                                    <td>
                                        <img src="uploads/client/<?php echo $row['image'] ?>" alt="" width="250px">
                                    </td>
                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo $row['is_active'] == 1 ? 'published' : 'drafted'; ?></td>
                                    <td>
                                        <a href="?page=tambah-client&edit=<?php echo $row['id'] ?>" class="btn btn-success">
                                            Edit
                                        </a>
                                        <a
                                            onclick="return confirm('Apakah anda yakin ingin mneghapus data?')"
                                            href="?page=tambah-client&delete=<?php echo $row['id'] ?>"
                                            class="btn btn-danger">
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>