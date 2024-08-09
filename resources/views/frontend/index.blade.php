<!DOCTYPE html>
<html lang="en">
<head>
    @include('frontend.includes.head')
</head>

   <body>
      <!-- navbar -->
      @include('frontend.includes.nav')

      <!-- Shop Cart -->
      @include('frontend.includes.cart')

      <main>
         @yield('content')
      </main>
            <!-- Modal -->
            <div class="modal fade" id="quickViewModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body p-8">
                            <div class="position-absolute top-0 end-0 me-3 mt-3">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <!-- Image Slide -->
                                    <div class="product productModal" id="productModal">
                                        <div class="zoom" onmousemove="zoom(event)" style="background-image: url({{ asset('frontend/assets/images/products/product-single-img-1.jpg') }})">
                                            <img src="{{ asset('frontend/assets/images/products/product-single-img-1.jpg') }}" alt="Product Image 1" />
                                        </div>
                                        <div>
                                            <div class="zoom" onmousemove="zoom(event)" style="background-image: url({{ asset('frontend/assets/images/products/product-single-img-2.jpg') }})">
                                                <img src="{{ asset('frontend/assets/images/products/product-single-img-2.jpg') }}" alt="Product Image 2" />
                                            </div>
                                        </div>
                                        <div>
                                            <div class="zoom" onmousemove="zoom(event)" style="background-image: url({{ asset('frontend/assets/images/products/product-single-img-3.jpg') }})">
                                                <img src="{{ asset('frontend/assets/images/products/product-single-img-3.jpg') }}" alt="Product Image 3" />
                                            </div>
                                        </div>
                                        <div>
                                            <div class="zoom" onmousemove="zoom(event)" style="background-image: url({{ asset('frontend/assets/images/products/product-single-img-4.jpg') }})">
                                                <img src="{{ asset('frontend/assets/images/products/product-single-img-4.jpg') }}" alt="Product Image 4" />
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Product Thumbnails -->
                                    <div class="product-tools">
                                        <div class="thumbnails row g-3" id="productModalThumbnails">
                                            <div class="col-3 tns-nav-active">
                                                <div class="thumbnails-img">
                                                    <img src="{{ asset('frontend/assets/images/products/product-single-img-1.jpg') }}" alt="Thumbnail 1" />
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="thumbnails-img">
                                                    <img src="{{ asset('frontend/assets/images/products/product-single-img-2.jpg') }}" alt="Thumbnail 2" />
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="thumbnails-img">
                                                    <img src="{{ asset('frontend/assets/images/products/product-single-img-3.jpg') }}" alt="Thumbnail 3" />
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="thumbnails-img">
                                                    <img src="{{ asset('frontend/assets/images/products/product-single-img-4.jpg') }}" alt="Thumbnail 4" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="ps-lg-8 mt-6 mt-lg-0">
                                        <a href="#!" class="mb-4 d-block">Bakery Biscuits</a>
                                        <h2 class="mb-1 h1">Napolitanke Ljesnjak</h2>
                                        <div class="mb-4">
                                            <small class="text-warning">
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-half"></i>
                                            </small>
                                            <a href="#" class="ms-2">(30 reviews)</a>
                                        </div>
                                        <div class="fs-4">
                                            <span class="fw-bold text-dark">$32</span>
                                            <span class="text-decoration-line-through text-muted">$35</span>
                                            <span><small class="fs-6 ms-2 text-danger">26% Off</small></span>
                                        </div>
                                        <hr class="my-6" />
                                        <div class="mb-4">
                                            <button type="button" class="btn btn-outline-secondary">250g</button>
                                            <button type="button" class="btn btn-outline-secondary">500g</button>
                                            <button type="button" class="btn btn-outline-secondary">1kg</button>
                                        </div>
                                        <div class="input-group input-spinner">
                                            <input type="button" value="-" class="button-minus btn btn-sm" data-field="quantity" />
                                            <input type="number" step="1" max="10" value="1" name="quantity" class="quantity-field form-control-sm form-input" />
                                            <input type="button" value="+" class="button-plus btn btn-sm" data-field="quantity" />
                                        </div>
                                        <div class="mt-3 row justify-content-start g-2 align-items-center">
                                            <div class="col-lg-4 col-md-5 col-6 d-grid">
                                                <button type="button" class="btn btn-primary">
                                                    <i class="feather-icon icon-shopping-bag me-2"></i>
                                                    Add to cart
                                                </button>
                                            </div>
                                            <div class="col-md-4 col-5">
                                                <a class="btn btn-light" href="#" data-bs-toggle="tooltip" data-bs-html="true" aria-label="Compare">
                                                    <i class="bi bi-arrow-left-right"></i>
                                                </a>
                                                <a class="btn btn-light" href="#!" data-bs-toggle="tooltip" data-bs-html="true" aria-label="Wishlist">
                                                    <i class="feather-icon icon-heart"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <hr class="my-6" />
                                        <div>
                                            <table class="table table-borderless">
                                                <tbody>
                                                    <tr>
                                                        <td>Product Code:</td>
                                                        <td>FBB00255</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Availability:</td>
                                                        <td>In Stock</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Type:</td>
                                                        <td>Fruits</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Shipping:</td>
                                                        <td>
                                                            <small>
                                                                01 day shipping.
                                                                <span class="text-muted">( Free pickup today)</span>
                                                            </small>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

      <!-- footer -->
      @include('frontend.includes.footer')

      <!-- Javascript-->

      <!-- Libs JS -->
      <!-- <script src="./assets/libs/jquery/dist/jquery.min.js"></script> -->
      <script src="{{ asset('frontend/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
      <script src="{{ asset('frontend/assets/libs/simplebar/dist/simplebar.min.js') }}"></script>

      <!-- Theme JS -->
      <script src="{{ asset('frontend/assets/js/theme.min.js') }}"></script>

      <script src="{{ asset('frontend/assets/js/vendors/jquery.min.js') }}"></script>
      <script src="{{ asset('frontend/assets/js/vendors/countdown.js') }}"></script>
      <script src="{{ asset('frontend/assets/libs/slick-carousel/slick/slick.min.js') }}"></script>
      <script src="{{ asset('frontend/assets/js/vendors/slick-slider.js') }}"></script>
      <script src="{{ asset('frontend/assets/libs/tiny-slider/dist/min/tiny-slider.js') }}"></script>
      <script src="{{ asset('frontend/assets/js/vendors/tns-slider.js') }}"></script>
      <script src="{{ asset('frontend/assets/js/vendors/zoom.js') }}"></script>
   </body>
</html>
