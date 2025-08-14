<?php
$query = mysqli_query($koneksi, "SELECT categories.name, blogs.* FROM blogs 
JOIN categories ON categories.id = blogs.id_category 
ORDER BY blogs.id DESC");
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
    <h1>Blogs Content</h1>
</div><!-- End Page Title -->

<section class="section">

    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Blogs Content</h5>

                    <div class="mb-3" align="right">
                        <a href="?page=tambah-blogs" class="btn btn-primary">Tambah</a>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Gambar</th>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($rows as $key => $row): ?>
                                <tr>
                                    <td><?php echo $key += 1; ?></td>
                                    <td>
                                        <img src="uploads/blogs/<?php echo $row['image'] ?>" alt="" width="250px">
                                    </td>
                                    <td><?php echo $row['title']; ?></td>
                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo changeIsActive($row['is_active']) ?></td>
                                    <td>
                                        <a href="?page=tambah-blogs&edit=<?php echo $row['id'] ?>" class="btn btn-success">
                                            Edit
                                        </a>
                                        <a
                                            onclick="return confirm('Apakah anda yakin ingin mneghapus data?')"
                                            href="?page=tambah-blogs&delete=<?php echo $row['id'] ?>"
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