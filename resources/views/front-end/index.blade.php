<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Upindo.web</title>
    <!-- fontawesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ=="
      crossorigin="anonymous"
        referrerpolicy="no-referrer" />
    <!-- bootstrap css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <!-- custom css -->
    <link rel="stylesheet" href="{{ asset('front-end/css/style.css') }}" />
</head>

<body>

    <div
        style="background-image: url({{ URL::asset('front-end/img/bg/vector2.jpg') }}); background-repeat: no-repeat; background-size: cover;">
        <!-- navbar -->
        <nav class = "navbar navbar-expand-lg navbar-light bg-white px-4 fixed-top shadow-sm">
            <div class = "container-fluid">
                <a class = "navbar-brand d-flex justify-content-between align-items-center order-lg-0" href = "#">
                    <img src = "{{ asset('front-end/img/loogoo (3).png') }}" alt = "site icon">
                    <span class = "text-uppercase fw-lighter ms-2"></span>
                </a>
                <button class = "navbar-toggler border-0" type = "button" data-bs-toggle = "collapse"
                    data-bs-target = "#navMenu">
                    <span class = "navbar-toggler-icon"></span>
                </button>
                <div class = "collapse navbar-collapse order-lg-1" id = "navMenu">
                    <ul class = "navbar-nav ms-auto">
                        <li class = "nav-item px-2 py-2">
                            <a class = "nav-link text-uppercase text-dark" href = "#">Home</a>
                        </li>
                        <li class = "nav-item px-2 py-2">
                            <a class = "nav-link text-uppercase text-dark" href = "#">Shop</a>
                        </li>
                        <li class = "nav-item px-2 py-2">
                            <a class = "nav-link text-uppercase text-dark" href = "#"><i class="fas fa-user-circle"
                                    style="font-size: 27px;"></i></a>
                        </li>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- end of navbar -->

        <div>

            <!-- header -->
            <section id="carousel">
                <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel"
                    style="padding-top: 10vh;">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="{{ asset('front-end/img/carousel.jpg') }}" alt="Image to Blur"
                                class="img-fluid  d-block w-100 h-100">
                            <div class="carousel-caption text-start text-dark"
                                style="max-width: 400px; margin-left: 20px; height: 450px;">
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('front-end/img/feature/ma2.png') }}" alt="Image to Blur"
                                class="img-fluid d-block w-100 h-100">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('front-end/img/feature/fromzero3.jpg') }}" alt="From zero To Hero"
                                class="img-fluid d-block w-100 h-100">
                            <div class="carousel-caption text-dark" style="height: 450px;">
                            </div>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </section>
            <!-- end of header -->

            <!-- about us -->
            <section id="collection" class="py-5 mx-3">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <h2 class="text-center">TENTANG KAMI</h2>
                            <div class="custom-horizontal-line"></div>
                            <div class="p-4 rounded-3 mt-4" style="background-color: rgba(5, 113, 5, 0.564)">
                                <h5 class="pt-4 text-center fw-bold">PT.Upindo Raya Semesta Borneo</h5>
                                <p class="text-light text-left">
                                    Kami adalah sebuah perusahaan distribusi, berkedudukan di Kota Samarinda, yang pada
                                    awal berdirinya pada tahun 2006 bernama UD. Upindo Raya.
                                    Sesuai dengan filosofi namanya saat ini,kami bercita-cita menjadi sebuah perusahan
                                    distribusi terbesar di Pulau Borneo.
                                    Area Coverage kami saat ini adalah Kalimantan Timur dan Kalimantan Utara, dan untuk
                                    membantu mendekatkan produk-produk yang kami distribusikan kepada para pelanggan,
                                    saat ini kami telah ditopang oleh Sembilan Mitra Distribusi yakni di Balikpapan,
                                    Tanah Grogot, Kutai Barat, Bontang, Sangata, Muara Wahau, Berau, Tanjung Selor dan
                                    Malinau. Dengan dukungan SDM yang kuat serta handal, dan support dari Para Suplayer,
                                    kami berkomitmen akan terus mengembangkan dan melebarkan sayap dengan membentuk
                                    mitra-mitra distribusi di berbagai area, baik didalam maupun diluar area coverage
                                    yang sudah ada.
                                    Agar lebih focus, Sistematis dan Bertanggungjawab, kami membagi kelompok suplayer
                                    kedalam Empat Devisi yakni :
                                <ol class="text-light">
                                    <li>Devisi Snack, Coklat & Candy</li>
                                    <li>Devisi Jelly & Minuman</li>
                                    <li>Devisi Biscuit, Wafer & Bakry</li>
                                    <li>Devisi Sembako</li>
                                </ol>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Start Produk Kami -->
            <section id = "collection" class = "py-5">
                <div class = "container">
                    <div class = "title text-center">
                        <h2>PRODUK KAMI</h2>
                        <div class="custom-horizontal-line"></div>
                    </div>
                    <div class = "row g-0">
                        <div class = "d-flex flex-wrap justify-content-center mt-5 filter-button-group">
                            <button type = "button" class = "btn m-2 text-dark active-filter-btn"
                                data-filter = "*">All</button>
                            <button type = "button" class = "btn m-2 text-dark" data-filter = ".Produk2">Produk
                                2</button>
                            <button type = "button" class = "btn m-2 text-dark" data-filter = ".Produk3">Produk
                                3</button>
                            <button type = "button" class = "btn m-2 text-dark" data-filter = ".Produk4">Produk
                                4</button>
                            <button type = "button" class = "btn m-2 text-dark" data-filter = ".Produk5">Produk
                                5</button>
                        </div>
                        <!-- bagian foto produk -->
                        <div class = "col-md-6 col-lg-4 col-xl-3 p-2 feat">
                            <div class="card" style="width: 18rem; margin: 10px;">
                                <img src="{{ asset('front-end/img/produk upindo/BISKUIT MELLISA BOX (10 G X 30 PCS X 16 BOX)-min.png') }}"
                                    class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">Nama Barang</h5>
                                    <span>-Stok Barang-</span><br>
                                    <span class = "fw-bold">Rp. Harga</span>
                                    <p class="card-text">Keterangan Barang.</p>
                                    <a href="detail.html" class="btn btn-primary">Lihat Barang</a>
                                    <a href="#" class="btn btn-primary"><i
                                            class="fas fa-shopping-cart"></i></span></a>
                                </div>
                            </div>
                        </div>

                        <div class = "col-md-6 col-lg-4 col-xl-3 p-2 feat">
                            <div class="card" style="width: 18rem; margin: 10px;">
                                <img src="img/produk upindo/BISKUIT MELLISA BOX (10 G X 30 PCS X 16 BOX)-min.png"
                                    class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">Nama Barang</h5>
                                    <span>-Stok Barang-</span><br>
                                    <span class = "fw-bold">Rp. Harga</span>
                                    <p class="card-text">Keterangan Barang.</p>
                                    <a href="detail.html" class="btn btn-primary">Lihat Barang</a>
                                    <a href="#" class="btn btn-primary"><i
                                            class="fas fa-shopping-cart"></i></span></a>
                                </div>
                            </div>
                        </div>

                        <div class = "col-md-6 col-lg-4 col-xl-3 p-2 feat">
                            <div class="card" style="width: 18rem; margin: 10px;">
                                <img src="img/produk upindo/BISKUIT MELLISA BOX (10 G X 30 PCS X 16 BOX)-min.png"
                                    class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">Nama Barang</h5>
                                    <span>-Stok Barang-</span><br>
                                    <span class = "fw-bold">Rp. Harga</span>
                                    <p class="card-text">Keterangan Barang.</p>
                                    <a href="detail.html" class="btn btn-primary">Lihat Barang</a>
                                    <a href="#" class="btn btn-primary"><i
                                            class="fas fa-shopping-cart"></i></span></a>
                                </div>
                            </div>
                        </div>

                        <div class = "col-md-6 col-lg-4 col-xl-3 p-2 feat">
                            <div class="card" style="width: 18rem; margin: 10px;">
                                <img src="img/produk upindo/BISKUIT MELLISA BOX (10 G X 30 PCS X 16 BOX)-min.png"
                                    class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">Nama Barang</h5>
                                    <span>-Stok Barang-</span><br>
                                    <span class = "fw-bold">Rp. Harga</span>
                                    <p class="card-text">Keterangan Barang.</p>
                                    <a href="detail.html" class="btn btn-primary">Lihat Barang</a>
                                    <a href="#" class="btn btn-primary"><i
                                            class="fas fa-shopping-cart"></i></span></a>
                                </div>
                            </div>
                        </div>

                        <div class = "col-md-6 col-lg-4 col-xl-3 p-2 feat">
                            <div class="card" style="width: 18rem; margin: 10px;">
                                <img src="img/produk upindo/BISKUIT MELLISA BOX (10 G X 30 PCS X 16 BOX)-min.png"
                                    class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">Nama Barang</h5>
                                    <span>-Stok Barang-</span><br>
                                    <span class = "fw-bold">Rp. Harga</span>
                                    <p class="card-text">Keterangan Barang.</p>
                                    <a href="detail.html" class="btn btn-primary">Lihat Barang</a>
                                    <a href="#" class="btn btn-primary"><i
                                            class="fas fa-shopping-cart"></i></span></a>
                                </div>
                            </div>
                        </div>

                        <div class = "col-md-6 col-lg-4 col-xl-3 p-2 feat">
                            <div class="card" style="width: 18rem; margin: 10px;">
                                <img src="img/produk upindo/BISKUIT MELLISA BOX (10 G X 30 PCS X 16 BOX)-min.png"
                                    class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">Nama Barang</h5>
                                    <span>-Stok Barang-</span><br>
                                    <span class = "fw-bold">Rp. Harga</span>
                                    <p class="card-text">Keterangan Barang.</p>
                                    <a href="detail.html" class="btn btn-primary">Lihat Barang</a>
                                    <a href="#" class="btn btn-primary"><i
                                            class="fas fa-shopping-cart"></i></span></a>
                                </div>
                            </div>
                        </div>

                        <div class = "col-md-6 col-lg-4 col-xl-3 p-2 feat">
                            <div class="card" style="width: 18rem; margin: 10px;">
                                <img src="img/produk upindo/BISKUIT MELLISA BOX (10 G X 30 PCS X 16 BOX)-min.png"
                                    class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">Nama Barang</h5>
                                    <span>-Stok Barang-</span><br>
                                    <span class = "fw-bold">Rp. Harga</span>
                                    <p class="card-text">Keterangan Barang.</p>
                                    <a href="detail.html" class="btn btn-primary">Lihat Barang</a>
                                    <a href="#" class="btn btn-primary"><i
                                            class="fas fa-shopping-cart"></i></span></a>
                                </div>
                            </div>
                        </div>

                        <div class = "col-md-6 col-lg-4 col-xl-3 p-2 feat">
                            <div class="card" style="width: 18rem; margin: 10px;">
                                <img src="img/produk upindo/BISKUIT MELLISA BOX (10 G X 30 PCS X 16 BOX)-min.png"
                                    class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">Nama Barang</h5>
                                    <span>-Stok Barang-</span><br>
                                    <span class = "fw-bold">Rp. Harga</span>
                                    <p class="card-text">Keterangan Barang.</p>
                                    <a href="detail.html" class="btn btn-primary">Lihat Barang</a>
                                    <a href="#" class="btn btn-primary"><i
                                            class="fas fa-shopping-cart"></i></span></a>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol "Lihat Lebih Lengkap" -->
                        <div class="container mt-5 text-end">
                            <a href="#" class="btn btn-primary">Lihat Lebih Lengkap <i
                                    class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </section>
            <!-- end Produk Kami -->

            <!-- Start Footer  -->
            <footer class="mt-5">
                <div class="copyright">
                    <p class="pt-2">Hak Cipta © 2023 | Kara Digital Solution</p>
                </div>
            </footer>

            <!-- isotope js -->
            <script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.js"></script>
            <!-- bootstrap js -->
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
                integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
            </script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
                integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
            </script>
            <!-- custom js -->
            <script src="js/script.js"></script>
        </div>
    </div>
</body>

</html>
