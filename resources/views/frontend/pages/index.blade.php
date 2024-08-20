@extends('frontend.index')
@section('content')
         <section class="mt-8">
            <div class="container">
               <div class="hero-slider">
                  <div style="background: url({{ asset('frontend/assets/images/slider/slide-1.jpg')}}) no-repeat; background-size: cover; border-radius: 0.5rem; background-position: center">
                     <div class="ps-lg-12 py-lg-16 col-xxl-5 col-md-7 py-14 px-8 text-xs-center">
                        <span class="badge text-bg-warning">Opening Sale Discount 50%</span>

                        <h2 class="text-dark display-5 fw-bold mt-4">SuperMarket For Fresh Grocery</h2>
                        <p class="lead">Introduced a new model for online grocery shopping and convenient home delivery.</p>
                        <a href="#!" class="btn btn-dark mt-3">
                           Shop Now
                           <i class="feather-icon icon-arrow-right ms-1"></i>
                        </a>
                     </div>
                  </div>
                  <div style="background: url({{ asset('frontend/assets/images/slider/slider-2.jpg')}}) no-repeat; background-size: cover; border-radius: 0.5rem; background-position: center">
                     <div class="ps-lg-12 py-lg-16 col-xxl-5 col-md-7 py-14 px-8 text-xs-center">
                        <span class="badge text-bg-warning">Free Shipping - orders over $100</span>
                        <h2 class="text-dark display-5 fw-bold mt-4">
                           Free Shipping on
                           <br />
                           orders over
                           <span class="text-primary">$100</span>
                        </h2>
                        <p class="lead">Free Shipping to First-Time Customers Only, After promotions and discounts are applied.</p>
                        <a href="#!" class="btn btn-dark mt-3">
                           Shop Now
                           <i class="feather-icon icon-arrow-right ms-1"></i>
                        </a>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <!-- Category Section Start-->
         <section class="mb-lg-10 mt-lg-14 my-8">
            <div class="container">
               <div class="row">
                  <div class="col-12 mb-6">
                     <h3 class="mb-0">Featured Categories</h3>
                  </div>
               </div>
               <div class="category-slider">
                    @foreach ($categories as $cat)
                            <div class="item">
                                <a href="" class="text-decoration-none text-inherit">
                                    <div class="card card-product mb-lg-4">
                                        <div class="card-body text-center py-8">
                                            <!-- img -->
                                            <img src="{{ Storage::url($cat?->media?->src) }}" alt="{{ $cat->name }}" class="mb-3 img-fluid" />

                                            <div class="text-truncate">{{ $cat->name }}</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                    @endforeach
               </div>
            </div>
         </section>
         <!-- Category Section End-->
         <section>
            <div class="container">
               <div class="row">
                  <div class="col-12 col-md-6 mb-3 mb-lg-0">
                     <div>
                        <div class="py-10 px-8 rounded" style="background: url({{ asset('frontend/assets/images/banner/grocery-banner.png')}}) no-repeat; background-size: cover; background-position: center">
                           <div>
                              <h3 class="fw-bold mb-1">Fruits & Vegetables</h3>
                              <p class="mb-4">
                                 Get Upto
                                 <span class="fw-bold">30%</span>
                                 Off
                              </p>
                              <a href="#!" class="btn btn-dark">Shop Now</a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-12 col-md-6">
                     <div>
                        <div class="py-10 px-8 rounded" style="background: url({{ asset('frontend/assets/images/banner/grocery-banner-2.jpg')}}) no-repeat; background-size: cover; background-position: center">
                           <div>
                              <h3 class="fw-bold mb-1">Freshly Baked Buns</h3>
                              <p class="mb-4">
                                 Get Upto
                                 <span class="fw-bold">25%</span>
                                 Off
                              </p>
                              <a href="#!" class="btn btn-dark">Shop Now</a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
                  <!-- Popular Packages Start-->
                  <section class="my-lg-14 my-8">
                    <div class="container">
                       <div class="row">
                          <div class="col-12 mb-6">
                             <h3 class="mb-0">Popular Packages</h3>
                          </div>
                       </div>

                       <div class="row g-4 row-cols-lg-5 row-cols-2 row-cols-md-3">
                            @foreach ($packages as $product)
                                <div class="col">
                                    <div class="card card-product">
                                        <div class="card-body">
                                            <div class="text-center position-relative">
                                                <!-- Sale Badge -->
                                                @if($product->discount_price && $product->discount_price < $product->price)
                                                    <div class="position-absolute top-0 start-0">
                                                        <span class="badge bg-danger">Sale</span>
                                                    </div>
                                                @endif
                                                <!-- Product Image -->
                                                @if($product->images->isNotEmpty())
                                                    <a href="{{ route('products.show', $product->id) }}">
                                                        <img src="{{ Storage::url($product->images->first()->media->src) }}" alt="{{ $product->name }}" class="mb-3 img-fluid" />
                                                    </a>
                                                @else
                                                    <a href="{{ route('products.show', $product->id) }}">
                                                        <img src="{{ asset('frontend/assets/images/products/default-product-image.jpg') }}" alt="{{ $product->name }}" class="mb-3 img-fluid" />
                                                    </a>
                                                @endif

                                                <!-- Product Actions -->
                                                <div class="card-product-action">
                                                    {{-- <a href="#!" class="btn-action" data-bs-toggle="modal" data-bs-target="#quickViewModal">
                                                        <i class="bi bi-eye" data-bs-toggle="tooltip" data-bs-html="true" title="Quick View"></i>
                                                    </a>
                                                    <a href="#!" class="btn-action" data-bs-toggle="tooltip" data-bs-html="true" title="Wishlist">
                                                        <i class="bi bi-heart"></i>
                                                    </a>
                                                    <a href="#!" class="btn-action" data-bs-toggle="tooltip" data-bs-html="true" title="Compare">
                                                        <i class="bi bi-arrow-left-right"></i>
                                                    </a> --}}
                                                </div>
                                            </div>

                                            <!-- Product Category -->
                                            <div class="text-small mb-1">
                                                <a href="#!" class="text-decoration-none text-muted">
                                                    <small>{{ $product->category->name ?? 'Uncategorized' }}</small>
                                                </a>
                                            </div>

                                            <!-- Product Name -->
                                            <h2 class="fs-6">
                                                <a href="{{ route('products.show', $product->id) }}" class="text-inherit text-decoration-none">
                                                    {{ $product->name }}
                                                </a>
                                            </h2>

                                            <!-- Product Rating -->
                                            <div>
                                                <small class="text-warning">
                                                    @for ($i = 0; $i < 5; $i++)
                                                        <i class="bi bi-star-fill"></i>
                                                    @endfor
                                                </small>
                                                <span class="text-muted small">{{ $product->reviews_count }} reviews</span>
                                            </div>

                                            <!-- Product Price -->
                                            <div class="d-flex justify-content-between align-items-center mt-3">
                                                <div>
                                                    @if($product->discount_price)
                                                        <span class="text-dark">${{ number_format($product->discount_price, 2) }}</span>
                                                        <span class="text-decoration-line-through text-muted">${{ number_format($product->price, 2) }}</span>
                                                    @else
                                                        <span class="text-dark">${{ number_format($product->price, 2) }}</span>
                                                    @endif
                                                </div>
                                                <div>
                                                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary btn-sm">
                                                        View
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach


                       </div>
                    </div>
                 </section>
         <!-- Popular Products Start-->
         <section class="my-lg-14 my-8">
            <div class="container">
               <div class="row">
                  <div class="col-12 mb-6">
                     <h3 class="mb-0">Popular Products</h3>
                  </div>
               </div>

               <div class="row g-4 row-cols-lg-5 row-cols-2 row-cols-md-3">
                    @foreach ($products as $product)
                        <div class="col">
                            <div class="card card-product">
                                <div class="card-body">
                                    <div class="text-center position-relative">
                                        <!-- Sale Badge -->
                                        @if($product->discount_price && $product->discount_price < $product->price)
                                            <div class="position-absolute top-0 start-0">
                                                <span class="badge bg-danger">Sale</span>
                                            </div>
                                        @endif
                                        <!-- Product Image -->
                                        @if($product->images->isNotEmpty())
                                            <a href="{{ route('products.show', $product->id) }}">
                                                <img src="{{ Storage::url($product->images->first()->media->src) }}" alt="{{ $product->name }}" class="mb-3 img-fluid" />
                                            </a>
                                        @else
                                            <a href="{{ route('products.show', $product->id) }}">
                                                <img src="{{ asset('frontend/assets/images/products/default-product-image.jpg') }}" alt="{{ $product->name }}" class="mb-3 img-fluid" />
                                            </a>
                                        @endif

                                        <!-- Product Actions -->
                                        <div class="card-product-action">
                                            {{-- <a href="#!" class="btn-action" data-bs-toggle="modal" data-bs-target="#quickViewModal">
                                                <i class="bi bi-eye" data-bs-toggle="tooltip" data-bs-html="true" title="Quick View"></i>
                                            </a>
                                            <a href="#!" class="btn-action" data-bs-toggle="tooltip" data-bs-html="true" title="Wishlist">
                                                <i class="bi bi-heart"></i>
                                            </a>
                                            <a href="#!" class="btn-action" data-bs-toggle="tooltip" data-bs-html="true" title="Compare">
                                                <i class="bi bi-arrow-left-right"></i>
                                            </a> --}}
                                        </div>
                                    </div>

                                    <!-- Product Category -->
                                    <div class="text-small mb-1">
                                        <a href="#!" class="text-decoration-none text-muted">
                                            <small>{{ $product->category->name ?? 'Uncategorized' }}</small>
                                        </a>
                                    </div>

                                    <!-- Product Name -->
                                    <h2 class="fs-6">
                                        <a href="{{ route('products.show', $product->id) }}" class="text-inherit text-decoration-none">
                                            {{ $product->name }}
                                        </a>
                                    </h2>

                                    <!-- Product Rating -->
                                    <div>
                                        <small class="text-warning">
                                            @for ($i = 0; $i < 5; $i++)
                                                <i class="bi bi-star-fill"></i>
                                            @endfor
                                        </small>
                                        <span class="text-muted small">{{ $product->reviews_count }} reviews</span>
                                    </div>

                                    <!-- Product Price -->
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <div>
                                            @if($product->discount_price)
                                                <span class="text-dark">${{ number_format($product->discount_price, 2) }}</span>
                                                <span class="text-decoration-line-through text-muted">${{ number_format($product->price, 2) }}</span>
                                            @else
                                                <span class="text-dark">${{ number_format($product->price, 2) }}</span>
                                            @endif
                                        </div>
                                        <div>
                                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary btn-sm">
                                                View
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach


               </div>
            </div>
         </section>
         <!-- Popular Products End-->
         <!--<section>-->
         <!--   <div class="container">-->
         <!--      <div class="row">-->
         <!--         <div class="col-md-12 mb-6">-->
         <!--            <h3 class="mb-0">Daily Best Sells</h3>-->
         <!--         </div>-->
         <!--      </div>-->
         <!--      <div class="table-responsive-lg pb-6">-->
         <!--         <div class="row row-cols-lg-4 row-cols-1 row-cols-md-2 g-4 flex-nowrap">-->
         <!--            <div class="col">-->
         <!--               <div class="pt-8 px-6 px-xl-8 rounded" style="background: url({{ asset('frontend/assets/images/banner/banner-deal.jpg')}}) no-repeat; background-size: cover; height: 470px">-->
         <!--                  <div>-->
         <!--                     <h3 class="fw-bold text-white">100% Organic Coffee Beans.</h3>-->
         <!--                     <p class="text-white">Get the best deal before close.</p>-->
         <!--                     <a href="#!" class="btn btn-primary">-->
         <!--                        Shop Now-->
         <!--                        <i class="feather-icon icon-arrow-right ms-1"></i>-->
         <!--                     </a>-->
         <!--                  </div>-->
         <!--               </div>-->
         <!--            </div>-->
         <!--            <div class="col">-->
         <!--               <div class="card card-product">-->
         <!--                  <div class="card-body">-->
         <!--                     <div class="text-center position-relative">-->
         <!--                        <a href="pages/shop-single.html"><img src="{{ asset('frontend/assets/images/products/product-img-11.jpg') }}" alt="Grocery Ecommerce Template" class="mb-3 img-fluid" /></a>-->

         <!--                        <div class="card-product-action">-->
         <!--                           <a href="#!" class="btn-action" data-bs-toggle="modal" data-bs-target="#quickViewModal">-->
         <!--                              <i class="bi bi-eye" data-bs-toggle="tooltip" data-bs-html="true" title="Quick View"></i>-->
         <!--                           </a>-->
         <!--                           <a href="#!" class="btn-action" data-bs-toggle="tooltip" data-bs-html="true" title="Wishlist"><i class="bi bi-heart"></i></a>-->
         <!--                           <a href="#!" class="btn-action" data-bs-toggle="tooltip" data-bs-html="true" title="Compare"><i class="bi bi-arrow-left-right"></i></a>-->
         <!--                        </div>-->
         <!--                     </div>-->
         <!--                     <div class="text-small mb-1">-->
         <!--                        <a href="#!" class="text-decoration-none text-muted"><small>Tea, Coffee & Drinks</small></a>-->
         <!--                     </div>-->
         <!--                     <h2 class="fs-6"><a href="pages/shop-single.html" class="text-inherit text-decoration-none">Roast Ground Coffee</a></h2>-->

         <!--                     <div class="d-flex justify-content-between align-items-center mt-3">-->
         <!--                        <div>-->
         <!--                           <span class="text-dark">$13</span>-->
         <!--                           <span class="text-decoration-line-through text-muted">$18</span>-->
         <!--                        </div>-->
         <!--                        <div>-->
         <!--                           <small class="text-warning">-->
         <!--                              <i class="bi bi-star-fill"></i>-->
         <!--                              <i class="bi bi-star-fill"></i>-->
         <!--                              <i class="bi bi-star-fill"></i>-->
         <!--                              <i class="bi bi-star-fill"></i>-->
         <!--                              <i class="bi bi-star-half"></i>-->
         <!--                           </small>-->
         <!--                           <span><small>4.5</small></span>-->
         <!--                        </div>-->
         <!--                     </div>-->
         <!--                     <div class="d-grid mt-2">-->
         <!--                        <a href="#!" class="btn btn-primary">-->
         <!--                           <svg-->
         <!--                              xmlns="http://www.w3.org/2000/svg"-->
         <!--                              width="16"-->
         <!--                              height="16"-->
         <!--                              viewBox="0 0 24 24"-->
         <!--                              fill="none"-->
         <!--                              stroke="currentColor"-->
         <!--                              stroke-width="2"-->
         <!--                              stroke-linecap="round"-->
         <!--                              stroke-linejoin="round"-->
         <!--                              class="feather feather-plus">-->
         <!--                              <line x1="12" y1="5" x2="12" y2="19"></line>-->
         <!--                              <line x1="5" y1="12" x2="19" y2="12"></line>-->
         <!--                           </svg>-->
         <!--                           Add to cart-->
         <!--                        </a>-->
         <!--                     </div>-->
         <!--                     <div class="d-flex justify-content-start text-center mt-3">-->
         <!--                        <div class="deals-countdown w-100" data-countdown="2028/10/10 00:00:00"></div>-->
         <!--                     </div>-->
         <!--                  </div>-->
         <!--               </div>-->
         <!--            </div>-->
         <!--            <div class="col">-->
         <!--               <div class="card card-product">-->
         <!--                  <div class="card-body">-->
         <!--                     <div class="text-center position-relative">-->
         <!--                        <a href="pages/shop-single.html"><img src="{{ asset('frontend/assets/images/products/product-img-12.jpg') }}" alt="Grocery Ecommerce Template" class="mb-3 img-fluid" /></a>-->
         <!--                        <div class="card-product-action">-->
         <!--                           <a href="#!" class="btn-action" data-bs-toggle="modal" data-bs-target="#quickViewModal">-->
         <!--                              <i class="bi bi-eye" data-bs-toggle="tooltip" data-bs-html="true" title="Quick View"></i>-->
         <!--                           </a>-->
         <!--                           <a href="#!" class="btn-action" data-bs-toggle="tooltip" data-bs-html="true" title="Wishlist"><i class="bi bi-heart"></i></a>-->
         <!--                           <a href="#!" class="btn-action" data-bs-toggle="tooltip" data-bs-html="true" title="Compare"><i class="bi bi-arrow-left-right"></i></a>-->
         <!--                        </div>-->
         <!--                     </div>-->
         <!--                     <div class="text-small mb-1">-->
         <!--                        <a href="#!" class="text-decoration-none text-muted"><small>Fruits & Vegetables</small></a>-->
         <!--                     </div>-->
         <!--                     <h2 class="fs-6"><a href="pages/shop-single.html" class="text-inherit text-decoration-none">Crushed Tomatoes</a></h2>-->
         <!--                     <div class="d-flex justify-content-between align-items-center mt-3">-->
         <!--                        <div>-->
         <!--                           <span class="text-dark">$13</span>-->
         <!--                           <span class="text-decoration-line-through text-muted">$18</span>-->
         <!--                        </div>-->
         <!--                        <div>-->
         <!--                           <small class="text-warning">-->
         <!--                              <i class="bi bi-star-fill"></i>-->
         <!--                              <i class="bi bi-star-fill"></i>-->
         <!--                              <i class="bi bi-star-fill"></i>-->
         <!--                              <i class="bi bi-star-fill"></i>-->
         <!--                              <i class="bi bi-star-half"></i>-->
         <!--                           </small>-->
         <!--                           <span><small>4.5</small></span>-->
         <!--                        </div>-->
         <!--                     </div>-->
         <!--                     <div class="d-grid mt-2">-->
         <!--                        <a href="#!" class="btn btn-primary">-->
         <!--                           <svg-->
         <!--                              xmlns="http://www.w3.org/2000/svg"-->
         <!--                              width="16"-->
         <!--                              height="16"-->
         <!--                              viewBox="0 0 24 24"-->
         <!--                              fill="none"-->
         <!--                              stroke="currentColor"-->
         <!--                              stroke-width="2"-->
         <!--                              stroke-linecap="round"-->
         <!--                              stroke-linejoin="round"-->
         <!--                              class="feather feather-plus">-->
         <!--                              <line x1="12" y1="5" x2="12" y2="19"></line>-->
         <!--                              <line x1="5" y1="12" x2="19" y2="12"></line>-->
         <!--                           </svg>-->
         <!--                           Add to cart-->
         <!--                        </a>-->
         <!--                     </div>-->
         <!--                     <div class="d-flex justify-content-start text-center mt-3 w-100">-->
         <!--                        <div class="deals-countdown w-100" data-countdown="2028/12/9 00:00:00"></div>-->
         <!--                     </div>-->
         <!--                  </div>-->
         <!--               </div>-->
         <!--            </div>-->
         <!--            <div class="col">-->
         <!--               <div class="card card-product">-->
         <!--                  <div class="card-body">-->
         <!--                     <div class="text-center position-relative">-->
         <!--                        <a href="pages/shop-single.html"><img src="{{ asset('frontend/assets/images/products/product-img-13.jpg') }}" alt="Grocery Ecommerce Template" class="mb-3 img-fluid" /></a>-->
         <!--                        <div class="card-product-action">-->
         <!--                           <a href="#!" class="btn-action" data-bs-toggle="modal" data-bs-target="#quickViewModal">-->
         <!--                              <i class="bi bi-eye" data-bs-toggle="tooltip" data-bs-html="true" title="Quick View"></i>-->
         <!--                           </a>-->
         <!--                           <a href="#!" class="btn-action" data-bs-toggle="tooltip" data-bs-html="true" title="Wishlist"><i class="bi bi-heart"></i></a>-->
         <!--                           <a href="#!" class="btn-action" data-bs-toggle="tooltip" data-bs-html="true" title="Compare"><i class="bi bi-arrow-left-right"></i></a>-->
         <!--                        </div>-->
         <!--                     </div>-->
         <!--                     <div class="text-small mb-1">-->
         <!--                        <a href="#!" class="text-decoration-none text-muted"><small>Fruits & Vegetables</small></a>-->
         <!--                     </div>-->
         <!--                     <h2 class="fs-6"><a href="pages/shop-single.html" class="text-inherit text-decoration-none">Golden Pineapple</a></h2>-->
         <!--                     <div class="d-flex justify-content-between align-items-center mt-3">-->
         <!--                        <div>-->
         <!--                           <span class="text-dark">$13</span>-->
         <!--                           <span class="text-decoration-line-through text-muted">$18</span>-->
         <!--                        </div>-->
         <!--                        <div>-->
         <!--                           <small class="text-warning">-->
         <!--                              <i class="bi bi-star-fill"></i>-->
         <!--                              <i class="bi bi-star-fill"></i>-->
         <!--                              <i class="bi bi-star-fill"></i>-->
         <!--                              <i class="bi bi-star-fill"></i>-->
         <!--                              <i class="bi bi-star-half"></i>-->
         <!--                           </small>-->
         <!--                           <span><small>4.5</small></span>-->
         <!--                        </div>-->
         <!--                     </div>-->
         <!--                     <div class="d-grid mt-2">-->
         <!--                        <a href="#!" class="btn btn-primary">-->
         <!--                           <svg-->
         <!--                              xmlns="http://www.w3.org/2000/svg"-->
         <!--                              width="16"-->
         <!--                              height="16"-->
         <!--                              viewBox="0 0 24 24"-->
         <!--                              fill="none"-->
         <!--                              stroke="currentColor"-->
         <!--                              stroke-width="2"-->
         <!--                              stroke-linecap="round"-->
         <!--                              stroke-linejoin="round"-->
         <!--                              class="feather feather-plus">-->
         <!--                              <line x1="12" y1="5" x2="12" y2="19"></line>-->
         <!--                              <line x1="5" y1="12" x2="19" y2="12"></line>-->
         <!--                           </svg>-->
         <!--                           Add to cart-->
         <!--                        </a>-->
         <!--                     </div>-->
         <!--                     <div class="d-flex justify-content-start text-center mt-3">-->
         <!--                        <div class="deals-countdown w-100" data-countdown="2028/11/11 00:00:00"></div>-->
         <!--                     </div>-->
         <!--                  </div>-->
         <!--               </div>-->
         <!--            </div>-->
         <!--         </div>-->
         <!--      </div>-->
         <!--   </div>-->
         <!--</section>-->
         <!--<section class="my-lg-14 my-8">-->
         <!--   <div class="container">-->
         <!--      <div class="row">-->
         <!--         <div class="col-md-6 col-lg-3">-->
         <!--            <div class="mb-8 mb-xl-0">-->
         <!--               <div class="mb-6"><img src="{{ asset('frontend/assets/images/icons/clock.svg') }}" alt="" /></div>-->
         <!--               <h3 class="h5 mb-3">10 minute grocery now</h3>-->
         <!--               <p>Get your order delivered to your doorstep at the earliest from FreshCart pickup stores near you.</p>-->
         <!--            </div>-->
         <!--         </div>-->
         <!--         <div class="col-md-6 col-lg-3">-->
         <!--            <div class="mb-8 mb-xl-0">-->
         <!--               <div class="mb-6"><img src="{{ asset('frontend/assets/images/icons/gift.svg') }}" alt="" /></div>-->
         <!--               <h3 class="h5 mb-3">Best Prices & Offers</h3>-->
         <!--               <p>Cheaper prices than your local supermarket, great cashback offers to top it off. Get best pricess & offers.</p>-->
         <!--            </div>-->
         <!--         </div>-->
         <!--         <div class="col-md-6 col-lg-3">-->
         <!--            <div class="mb-8 mb-xl-0">-->
         <!--               <div class="mb-6"><img src="{{ asset('frontend/assets/images/icons/package.svg') }}" alt="" /></div>-->
         <!--               <h3 class="h5 mb-3">Wide Assortment</h3>-->
         <!--               <p>Choose from 5000+ products across food, personal care, household, bakery, veg and non-veg & other categories.</p>-->
         <!--            </div>-->
         <!--         </div>-->
         <!--         <div class="col-md-6 col-lg-3">-->
         <!--            <div class="mb-8 mb-xl-0">-->
         <!--               <div class="mb-6"><img src="{{ asset('frontend/assets/images/icons/refresh-cw.svg') }}" alt="" /></div>-->
         <!--               <h3 class="h5 mb-3">Easy Returns</h3>-->
         <!--               <p>-->
         <!--                  Not satisfied with a product? Return it at the doorstep & get a refund within hours. No questions asked-->
         <!--                  <a href="#!">policy</a>-->
         <!--                  .-->
         <!--               </p>-->
         <!--            </div>-->
         <!--         </div>-->
         <!--      </div>-->
         <!--   </div>-->
         <!--</section>-->
@endsection
