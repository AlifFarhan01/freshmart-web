 <!-- Tastimonial Start -->
 <section id="testimoni" class="section">
     <div class="container-fluid testimonial py-5">
         <div class="container py-5">
             <div class="testimonial-header text-center">
                 <h4 class="text-primary">Our Testimonial</h4>
                 <h1 class="display-5 mb-5 text-dark">Our Client Saying!</h1>
             </div>
             <div class="owl-carousel testimonial-carousel">
                 @foreach ($reviews as $review)
                     <div class="testimonial-item img-border-radius bg-light rounded p-4">
                         <div class="position-relative">
                             <i class="fa fa-quote-right fa-2x text-secondary position-absolute"
                                 style="bottom: 30px; right: 0;"></i>
                             <div class="mb-4 pb-4 border-bottom border-secondary">
                                 <p class="mb-0">{{ $review->review }}
                                 </p>

                             </div>
                             <div class="d-flex align-items-center flex-nowrap">

                                 <div class="ms-4 d-block">
                                     <h4 class="text-dark">{{ $review->user->name }}</h4>
                                     <div class="d-flex pe-5">
                                         @for ($i = 1; $i <= 5; $i++)
                                             @if ($i <= $review->rating)
                                                 <i class="fas fa-star text-primary"></i>
                                             @else
                                                 <i class="fas fa-star"></i>
                                             @endif
                                         @endfor
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 @endforeach
             </div>
         </div>
     </div>
 </section>
 <!-- Tastimonial End -->
