<?php
$queryBlogs = mysqli_query($koneksi, "SELECT categories.name, blogs.* FROM blogs 
JOIN categories ON categories.id = blogs.id_category 
ORDER BY blogs.id DESC");
$rowBlogs = mysqli_fetch_all($queryBlogs, MYSQLI_ASSOC);
?>
<!-- Page Title -->
<div class="page-title accent-background">
  <div class="container d-lg-flex justify-content-between align-items-center">
    <h1 class="mb-2 mb-lg-0">Blog</h1>
    <nav class="breadcrumbs">
      <ol>
        <li><a href="index.html">Home</a></li>
        <li class="current">Blog</li>
      </ol>
    </nav>
  </div>
</div><!-- End Page Title -->

<!-- Blog Posts Section -->
<section id="blog-posts" class="blog-posts section">

  <div class="container">
    <div class="row gy-4">
      <?php foreach ($rowBlogs as $key => $blog): ?>
        <div class="col-lg-4">
          <article class="position-relative h-100">

            <div class="post-img position-relative overflow-hidden">
              <img src="admin/uploads/blogs/<?php echo $blog['image'] ?>" class="img-fluid" alt="">
              <span class="post-date"><?php echo $blog['created_at'] ?></span>
            </div>

            <div class="post-content d-flex flex-column">

              <h3 class="post-title"><?php echo $blog['title'] ?></h3>

              <div class="meta d-flex align-items-center">
                <div class="d-flex align-items-center">
                  <i class="bi bi-person"></i> <span class="ps-2"><?php echo $blog['penulis'] ?></span>
                </div>
                <span class="px-3 text-black-50">/</span>
                <div class="d-flex align-items-center">
                  <i class="bi bi-folder2"></i> <span class="ps-2"><?php echo $blog['name'] ?></span>
                </div>
              </div>

              <p>
                <?php echo substr($blog['content'], 0, 50) ?>...
              </p>

              <hr>

              <a href="?page=blog-details&id=<?php echo $blog['id'] ?>" class="readmore stretched-link"><span>Read More</span><i class="bi bi-arrow-right"></i></a>

            </div>

          </article>
        </div><!-- End post list item -->
      <?php endforeach; ?>
    </div>
  </div>

</section><!-- /Blog Posts Section -->

<!-- Blog Pagination Section -->
<section id="blog-pagination" class="blog-pagination section">

  <div class="container">
    <div class="d-flex justify-content-center">
      <ul>
        <li><a href="#"><i class="bi bi-chevron-left"></i></a></li>
        <li><a href="#">1</a></li>
        <li><a href="#" class="active">2</a></li>
        <li><a href="#">3</a></li>
        <li><a href="#">4</a></li>
        <li>...</li>
        <li><a href="#">10</a></li>
        <li><a href="#"><i class="bi bi-chevron-right"></i></a></li>
      </ul>
    </div>
  </div>

</section><!-- /Blog Pagination Section -->