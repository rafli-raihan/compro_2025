<?php
$query = mysqli_query($koneksi, "SELECT categories.name, portofolio.* FROM portofolio 
JOIN categories ON categories.id = portofolio.id_category 
ORDER BY portofolio.id DESC");
$rows = mysqli_fetch_all($query, MYSQLI_ASSOC);

function changeIsActive($isActive)
{
    switch ($isActive) {
        case '1':
            $title = "<span class='badge bg-primary'>Publish</span>";
            break;

        default:
            $title = "<span class='badge bg-primary'>Draft</span>";
            break;
    }

    return $title;
}
?>

<div class="pagetitle">
    <h1>Portofolio Content</h1>
</div><!-- End Page Title -->

<section class="section">

    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Portofolio Content</h5>

                    <div class="mb-3" align="right">
                        <a href="?page=tambah-portofolio" class="btn btn-primary">Tambah</a>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Gambar</th>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Nama Client</th>
                                <th>Tanggal Proyek</th>
                                <th>Link Proyek</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($rows as $key => $row): ?>
                                <tr>
                                    <td><?php echo $key += 1; ?></td>
                                    <td>
                                        <img src="uploads/portofolio/<?php echo $row['image'] ?>" alt="" width="250px">
                                    </td>
                                    <td><?php echo $row['title']; ?></td>
                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo $row['client_name']; ?></td>
                                    <td><?php echo $row['project_date']; ?></td>
                                    <td><?php echo $row['project_url']; ?></td>
                                    <td><?php echo changeIsActive($row['is_active']) ?></td>
                                    <td>
                                        <a href="?page=tambah-portofolio&edit=<?php echo $row['id'] ?>" class="btn btn-success">
                                            Edit
                                        </a>
                                        <a
                                            onclick="return confirm('Apakah anda yakin ingin mneghapus data?')"
                                            href="?page=tambah-portofolio&delete=<?php echo $row['id'] ?>"
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