  <section id="FAQ" class="section">
      <div class="container-fluid testimonial py-5">
          <div class="container py-5">
              <div class="testimonial-header text-center">
                  <h1 class="display-5 mb-5 text-dark">FAQ</h1>
              </div>
              <div class="row">
                  @php
                      $leftFaqs = $faq->slice(0, ceil($faq->count() / 2));
                      $rightFaqs = $faq->slice(ceil($faq->count() / 2));
                  @endphp

                  <div class="col-md-6">
                      <div class="accordion" id="accordionFaqLeft">
                          @foreach ($leftFaqs as $index => $faqItem)
                              <div class="accordion-item">
                                  <h2 class="accordion-header" id="headingLeft{{ $index }}">
                                      <button class="accordion-button collapsed" type="button"
                                          data-bs-toggle="collapse" data-bs-target="#collapseLeft{{ $index }}"
                                          aria-expanded="false" aria-controls="collapseLeft{{ $index }}">
                                          {{ $faqItem->pertanyaan }}
                                      </button>
                                  </h2>
                                  <div id="collapseLeft{{ $index }}" class="accordion-collapse collapse"
                                      aria-labelledby="headingLeft{{ $index }}"
                                      data-bs-parent="#accordionFaqLeft">
                                      <div class="accordion-body">
                                          {{ $faqItem->jawaban }}
                                      </div>
                                  </div>
                              </div>
                          @endforeach
                      </div>
                  </div>

                  <div class="col-md-6">
                      <div class="accordion" id="accordionFaqRight">
                          @foreach ($rightFaqs as $index => $faqItem)
                              <div class="accordion-item">
                                  <h2 class="accordion-header" id="headingRight{{ $index + $leftFaqs->count() }}">
                                      <button class="accordion-button collapsed" type="button"
                                          data-bs-toggle="collapse"
                                          data-bs-target="#collapseRight{{ $index + $leftFaqs->count() }}"
                                          aria-expanded="false"
                                          aria-controls="collapseRight{{ $index + $leftFaqs->count() }}">
                                          {{ $faqItem->pertanyaan }}
                                      </button>
                                  </h2>
                                  <div id="collapseRight{{ $index + $leftFaqs->count() }}"
                                      class="accordion-collapse collapse"
                                      aria-labelledby="headingRight{{ $index + $leftFaqs->count() }}"
                                      data-bs-parent="#accordionFaqRight">
                                      <div class="accordion-body">
                                          {{ $faqItem->jawaban }}
                                      </div>
                                  </div>
                              </div>
                          @endforeach
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </section>
