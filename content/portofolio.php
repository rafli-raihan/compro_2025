    <?php
    $queryPortofolio = mysqli_query($koneksi, "SELECT categories.name, categories.id as id_cat, portofolio.* FROM portofolio 
    LEFT JOIN categories ON categories.id = portofolio.id_category 
    ORDER BY portofolio.id DESC");
    $rowPortofolio = mysqli_fetch_all($queryPortofolio, MYSQLI_ASSOC);

    $queryCategory = mysqli_query($koneksi, "SELECT * FROM categories WHERE type='portofolio' ORDER BY id DESC");
    $rowCategory = mysqli_fetch_all($queryCategory, MYSQLI_ASSOC);
    ?>

    <div class="page-title accent-background">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">Portfolio</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="index.html">Home</a></li>
                    <li class="current">Portfolio</li>
                </ol>
            </nav>
        </div>
    </div><!-- End Page Title -->

    <!-- Portfolio Section -->
    <section id="portfolio" class="portfolio section">

        <div class="container">

            <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">

                <ul class="portfolio-filters isotope-filters" data-aos="fade-up" data-aos-delay="100">
                    <li data-filter="*" class="filter-active">All</li>
                    <?php foreach ($rowPortofolio as $key => $portofolio): ?>
                        <li data-filter=".filter-<?php echo $portofolio['id_cat'] ?>"><?php echo $portofolio['name'] ?></li>
                    <?php endforeach ?>
                </ul><!-- End Portfolio Filters -->

                <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">
                    <?php foreach ($rowPortofolio as $key => $portoitems): ?>
                        <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-<?php echo $portoitems['id_cat'] ?>">
                            <img src="admin/uploads/portofolio/<?php echo $portoitems['image'] ?>" class="img-fluid" alt="">
                            <div class="portfolio-info">
                                <h4><?php echo $portoitems['title'] ?></h4>
                                <p><?php echo $portoitems['content'] ?></p>
                                <a href="admin/uploads/portofolio/<?php echo $portoitems['image'] ?>" title="<?php echo $portoitems['title'] ?>" data-gallery=" portfolio-gallery-app" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                                <a href="?page=portofolio-details" title="More Details" class="details-link"><i class="bi bi-link-45deg"></i></a>
                            </div>
                        </div><!-- End Portfolio Item -->
                    <?php endforeach ?>
                </div><!-- End Portfolio Container -->

            </div>

        </div>

    </section><!-- /Portfolio Section -->