    <?php
    $id = isset($_GET['id']) ? $_GET['id'] : '';
    $queryBlog = mysqli_query($koneksi, "SELECT categories.name, blogs.* FROM blogs 
    JOIN categories ON categories.id = blogs.id_category 
    WHERE blogs.id = '$id'");
    $rowBlog = mysqli_fetch_assoc($queryBlog);

    $query_recentBlog = mysqli_query($koneksi, "SELECT categories.name, blogs.* FROM blogs 
    JOIN categories ON categories.id = blogs.id_category 
    LIMIT 5");
    $row_recentBlog = mysqli_fetch_all($query_recentBlog, MYSQLI_ASSOC);
    ?>

    <!-- Page Title -->
    <div class="page-title accent-background">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">Blog Details</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="index.html">Home</a></li>
                    <li class="current">Blog Details</li>
                </ol>
            </nav>
        </div>
    </div><!-- End Page Title -->

    <div class="container">
        <div class="row">

            <div class="col-lg-8">

                <!-- Blog Details Section -->
                <section id="blog-details" class="blog-details section">
                    <div class="container">

                        <article class="article">

                            <div class="post-img">
                                <img src="admin/uploads/blogs/<?php echo $rowBlog['image'] ?>" alt="" class="img-fluid">
                            </div>

                            <h2 class="title"><?php echo $rowBlog['title'] ?></h2>

                            <div class="meta-top">
                                <ul>
                                    <li class="d-flex align-items-center"><i class="bi bi-person"></i> <a href="blog-details.html"><?php echo $rowBlog['penulis'] ?></a></li>
                                    <li class="d-flex align-items-center"><i class="bi bi-clock"></i> <a href="blog-details.html"><?php echo $rowBlog['created_at'] ?></a></li>
                                    <!-- <li class="d-flex align-items-center"><i class="bi bi-chat-dots"></i> <a href="blog-details.html">12 Comments</a></li> -->
                                </ul>
                            </div><!-- End meta top -->

                            <div class="content">
                                <?php echo $rowBlog['content'] ?>
                            </div><!-- End post content -->

                            <div class="meta-bottom">
                                <i class="bi bi-folder"></i>
                                <ul class="cats">
                                    <li><a href="#"><?php echo $rowBlog['name'] ?></a></li>
                                </ul>

                                <?php
                                $tags = json_decode($rowBlog['tags'], true); # ini buat convert Map / List ke Array biasa (asosiatif) jadi bisa di print make foreach
                                ?>

                                <i class="bi bi-tags"></i>
                                <ul class="tags">
                                    <?php foreach ($tags as $tag): ?>
                                        <li><a href="#"><?php echo $tag['value'] ?></a></li>
                                    <?php endforeach ?>
                                </ul>
                            </div><!-- End meta bottom -->

                        </article>

                    </div>
                </section><!-- /Blog Details Section -->

                <!-- Comment Form Section -->
                <!-- <section id="comment-form" class="comment-form section">
                    <div class="container">

                        <form action="">

                            <h4>Post Comment</h4>
                            <p>Your email address will not be published. Required fields are marked * </p>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <input name="name" type="text" class="form-control" placeholder="Your Name*">
                                </div>
                                <div class="col-md-6 form-group">
                                    <input name="email" type="text" class="form-control" placeholder="Your Email*">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col form-group">
                                    <input name="website" type="text" class="form-control" placeholder="Your Website">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col form-group">
                                    <textarea name="comment" class="form-control" placeholder="Your Comment*"></textarea>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Post Comment</button>
                            </div>

                        </form>

                    </div>
                </section> Comment Form Section -->

            </div>

            <div class="col-lg-4 sidebar">

                <div class="widgets-container">
                    <!-- Search Widget -->
                    <div class="search-widget widget-item">

                        <h3 class="widget-title">Search</h3>
                        <form action="">
                            <input type="text">
                            <button type="submit" title="Search"><i class="bi bi-search"></i></button>
                        </form>

                    </div><!--/Search Widget -->

                    <!-- Recent Posts Widget -->
                    <div class="recent-posts-widget widget-item">

                        <h3 class="widget-title">Recent Posts</h3>
                        <?php foreach ($row_recentBlog as $key => $recentBlogs): ?>
                            <div class="post-item">
                                <h4><a href="blog-details.html"><?php echo $recentBlogs['title'] ?></a></h4>
                                <time><?php echo $recentBlogs['created_at'] ?></time>
                            </div><!-- End recent post item-->
                        <?php endforeach ?>
                    </div><!--/Recent Posts Widget -->

                    <!-- Tags Widget -->
                    <div class="tags-widget widget-item">

                        <h3 class="widget-title">Tags</h3>
                        <ul>
                            <li><a href="#">App</a></li>
                            <li><a href="#">IT</a></li>
                            <li><a href="#">Business</a></li>
                            <li><a href="#">Mac</a></li>
                            <li><a href="#">Design</a></li>
                            <li><a href="#">Office</a></li>
                            <li><a href="#">Creative</a></li>
                            <li><a href="#">Studio</a></li>
                            <li><a href="#">Smart</a></li>
                            <li><a href="#">Tips</a></li>
                            <li><a href="#">Marketing</a></li>
                        </ul>

                    </div><!--/Tags Widget -->

                </div>

            </div>

        </div>
    </div>