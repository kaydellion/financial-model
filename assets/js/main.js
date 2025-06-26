/**
* Template Name: eStore
* Template URL: https://bootstrapmade.com/estore-bootstrap-ecommerce-template/
* Updated: Apr 26 2025 with Bootstrap v5.3.5
* Author: BootstrapMade.com
* License: https://bootstrapmade.com/license/
*/

(function() {
  "use strict";

  /**
   * Apply .scrolled class to the body as the page is scrolled down
   */
  function toggleScrolled() {
    const selectBody = document.querySelector('body');
    const selectHeader = document.querySelector('#header');
    if (!selectHeader.classList.contains('scroll-up-sticky') && !selectHeader.classList.contains('sticky-top') && !selectHeader.classList.contains('fixed-top')) return;
    window.scrollY > 100 ? selectBody.classList.add('scrolled') : selectBody.classList.remove('scrolled');
  }

  document.addEventListener('scroll', toggleScrolled);
  window.addEventListener('load', toggleScrolled);

  /**
   * Init swiper sliders
   */
  function initSwiper() {
    document.querySelectorAll(".init-swiper").forEach(function(swiperElement) {
      let config = JSON.parse(
        swiperElement.querySelector(".swiper-config").innerHTML.trim()
      );

      if (swiperElement.classList.contains("swiper-tab")) {
        initSwiperWithCustomPagination(swiperElement, config);
      } else {
        new Swiper(swiperElement, config);
      }
    });
  }

  window.addEventListener("load", initSwiper);

  /**
   * Mobile nav toggle
   */
  const mobileNavToggleBtn = document.querySelector('.mobile-nav-toggle');

  function mobileNavToogle() {
    document.querySelector('body').classList.toggle('mobile-nav-active');
    mobileNavToggleBtn.classList.toggle('bi-list');
    mobileNavToggleBtn.classList.toggle('bi-x');
  }
  if (mobileNavToggleBtn) {
    mobileNavToggleBtn.addEventListener('click', mobileNavToogle);
  }

  /**
   * Hide mobile nav on same-page/hash links
   */
  document.querySelectorAll('#navmenu a').forEach(navmenu => {
    navmenu.addEventListener('click', () => {
      if (document.querySelector('.mobile-nav-active')) {
        mobileNavToogle();
      }
    });

  });

  /**
   * Toggle mobile nav dropdowns
   */
  document.querySelectorAll('.navmenu .toggle-dropdown').forEach(navmenu => {
    navmenu.addEventListener('click', function(e) {
      e.preventDefault();
      this.parentNode.classList.toggle('active');
      this.parentNode.nextElementSibling.classList.toggle('dropdown-active');
      e.stopImmediatePropagation();
    });
  });

  // read more read less
   document.addEventListener("DOMContentLoaded", function () {
    const readMoreButtons = document.querySelectorAll(".read-mores-btn");

    readMoreButtons.forEach(button => {
        button.addEventListener("click", function (event) {
            event.preventDefault(); // Prevent the default behavior (e.g., page reload)

            const bioPreview = this.previousElementSibling.previousElementSibling; // The preview text
            const bioFull = this.previousElementSibling; // The full text

            if (bioFull.style.display === "none") {
                bioFull.style.display = "inline";
                bioPreview.style.display = "none";
                this.textContent = "Read Less";
            } else {
                bioFull.style.display = "none";
                bioPreview.style.display = "inline";
                this.textContent = "Read More";
            }
        });
    });
});


  /**
   * Preloader
   */
  const preloader = document.querySelector('#preloader');
  if (preloader) {
    window.addEventListener('load', () => {
      preloader.remove();
    });
  }

  /**
   * Scroll top button
   */
  let scrollTop = document.querySelector('.scroll-top');

  function toggleScrollTop() {
    if (scrollTop) {
      window.scrollY > 100 ? scrollTop.classList.add('active') : scrollTop.classList.remove('active');
    }
  }
  scrollTop.addEventListener('click', (e) => {
    e.preventDefault();
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });

  window.addEventListener('load', toggleScrollTop);
  document.addEventListener('scroll', toggleScrollTop);

  /**
   * Animation on scroll function and init
   */
  function aosInit() {
    AOS.init({
      duration: 600,
      easing: 'ease-in-out',
      once: true,
      mirror: false
    });
  }
  window.addEventListener('load', aosInit);

  /**
   * Init isotope layout and filters
   */
  document.querySelectorAll('.isotope-layout').forEach(function(isotopeItem) {
    let layout = isotopeItem.getAttribute('data-layout') ?? 'masonry';
    let filter = isotopeItem.getAttribute('data-default-filter') ?? '*';
    let sort = isotopeItem.getAttribute('data-sort') ?? 'original-order';

    let initIsotope;
    imagesLoaded(isotopeItem.querySelector('.isotope-container'), function() {
      initIsotope = new Isotope(isotopeItem.querySelector('.isotope-container'), {
        itemSelector: '.isotope-item',
        layoutMode: layout,
        filter: filter,
        sortBy: sort
      });
    });

    isotopeItem.querySelectorAll('.isotope-filters li').forEach(function(filters) {
      filters.addEventListener('click', function() {
        isotopeItem.querySelector('.isotope-filters .filter-active').classList.remove('filter-active');
        this.classList.add('filter-active');
        initIsotope.arrange({
          filter: this.getAttribute('data-filter')
        });
        if (typeof aosInit === 'function') {
          aosInit();
        }
      }, false);
    });

  });

  /**
   * Ecommerce Cart Functionality
   * Handles quantity changes and item removal
   */



//password eye
 


  /**
   * Product Image Zoom and Thumbnail Functionality
   */

  function productDetailFeatures() {
    // Initialize Drift for image zoom
    function initDriftZoom() {
      // Check if Drift is available
      if (typeof Drift === 'undefined') {
        console.error('Drift library is not loaded');
        return;
      }

      const driftOptions = {
        paneContainer: document.querySelector('.image-zoom-container'),
        inlinePane: window.innerWidth < 768 ? true : false,
        inlineOffsetY: -85,
        containInline: true,
        hoverBoundingBox: false,
        zoomFactor: 3,
        handleTouch: false
      };

      // Initialize Drift on the main product image
      const mainImage = document.getElementById('main-product-image');
      if (mainImage) {
        new Drift(mainImage, driftOptions);
      }
    }

    // Thumbnail click functionality
    function initThumbnailClick() {
      const thumbnails = document.querySelectorAll('.thumbnail-item');
      const mainImage = document.getElementById('main-product-image');

      if (!thumbnails.length || !mainImage) return;

      thumbnails.forEach(thumbnail => {
        thumbnail.addEventListener('click', function() {
          // Get image path from data attribute
          const imageSrc = this.getAttribute('data-image');

          // Update main image src and zoom attribute
          mainImage.src = imageSrc;
          mainImage.setAttribute('data-zoom', imageSrc);

          // Update active state
          thumbnails.forEach(item => item.classList.remove('active'));
          this.classList.add('active');

          // Reinitialize Drift for the new image
          initDriftZoom();
        });
      });
    }

    // Image navigation functionality (prev/next buttons)
    function initImageNavigation() {
      const prevButton = document.querySelector('.image-nav-btn.prev-image');
      const nextButton = document.querySelector('.image-nav-btn.next-image');

      if (!prevButton || !nextButton) return;

      const thumbnails = Array.from(document.querySelectorAll('.thumbnail-item'));
      if (!thumbnails.length) return;

      // Function to navigate to previous or next image
      function navigateImage(direction) {
        // Find the currently active thumbnail
        const activeIndex = thumbnails.findIndex(thumb => thumb.classList.contains('active'));
        if (activeIndex === -1) return;

        let newIndex;
        if (direction === 'prev') {
          // Go to previous image or loop to the last one
          newIndex = activeIndex === 0 ? thumbnails.length - 1 : activeIndex - 1;
        } else {
          // Go to next image or loop to the first one
          newIndex = activeIndex === thumbnails.length - 1 ? 0 : activeIndex + 1;
        }

        // Simulate click on the new thumbnail
        thumbnails[newIndex].click();
      }

      // Add event listeners to navigation buttons
      prevButton.addEventListener('click', () => navigateImage('prev'));
      nextButton.addEventListener('click', () => navigateImage('next'));
    }

    // Initialize all features
    initDriftZoom();
    initThumbnailClick();
    initImageNavigation();
  }

  productDetailFeatures();

  /**
   * Price range slider implementation for price filtering.
   */
  function priceRangeWidget() {
    // Get all price range widgets on the page
    const priceRangeWidgets = document.querySelectorAll('.price-range-container');

    priceRangeWidgets.forEach(widget => {
      const minRange = widget.querySelector('.min-range');
      const maxRange = widget.querySelector('.max-range');
      const sliderProgress = widget.querySelector('.slider-progress');
      const minPriceDisplay = widget.querySelector('.current-range .min-price');
      const maxPriceDisplay = widget.querySelector('.current-range .max-price');
      const minPriceInput = widget.querySelector('.min-price-input');
      const maxPriceInput = widget.querySelector('.max-price-input');
      const applyButton = widget.querySelector('.filter-actions .btn-primary');

      if (!minRange || !maxRange || !sliderProgress || !minPriceDisplay || !maxPriceDisplay || !minPriceInput || !maxPriceInput) return;

      // Slider configuration
      const sliderMin = parseInt(minRange.min);
      const sliderMax = parseInt(minRange.max);
      const step = parseInt(minRange.step) || 1;

      // Initialize with default values
      let minValue = parseInt(minRange.value);
      let maxValue = parseInt(maxRange.value);

      // Set initial values
      updateSliderProgress();
      updateDisplays();

      // Min range input event
      minRange.addEventListener('input', function() {
        minValue = parseInt(this.value);

        // Ensure min doesn't exceed max
        if (minValue > maxValue) {
          minValue = maxValue;
          this.value = minValue;
        }

        // Update min price input and display
        minPriceInput.value = minValue;
        updateDisplays();
        updateSliderProgress();
      });

      // Max range input event
      maxRange.addEventListener('input', function() {
        maxValue = parseInt(this.value);

        // Ensure max isn't less than min
        if (maxValue < minValue) {
          maxValue = minValue;
          this.value = maxValue;
        }

        // Update max price input and display
        maxPriceInput.value = maxValue;
        updateDisplays();
        updateSliderProgress();
      });

      // Min price input change
      minPriceInput.addEventListener('change', function() {
        let value = parseInt(this.value) || sliderMin;

        // Ensure value is within range
        value = Math.max(sliderMin, Math.min(sliderMax, value));

        // Ensure min doesn't exceed max
        if (value > maxValue) {
          value = maxValue;
        }

        // Update min value and range input
        minValue = value;
        this.value = value;
        minRange.value = value;
        updateDisplays();
        updateSliderProgress();
      });

      // Max price input change
      maxPriceInput.addEventListener('change', function() {
        let value = parseInt(this.value) || sliderMax;

        // Ensure value is within range
        value = Math.max(sliderMin, Math.min(sliderMax, value));

        // Ensure max isn't less than min
        if (value < minValue) {
          value = minValue;
        }

        // Update max value and range input
        maxValue = value;
        this.value = value;
        maxRange.value = value;
        updateDisplays();
        updateSliderProgress();
      });

      // Apply button click
      if (applyButton) {
        applyButton.addEventListener('click', function() {
          // This would typically trigger a form submission or AJAX request
          console.log(`Applying price filter: $${minValue} - $${maxValue}`);

          // Here you would typically add code to filter products or redirect to a filtered URL
        });
      }

      // Helper function to update the slider progress bar
      function updateSliderProgress() {
        const range = sliderMax - sliderMin;
        const minPercent = ((minValue - sliderMin) / range) * 100;
        const maxPercent = ((maxValue - sliderMin) / range) * 100;

        sliderProgress.style.left = `${minPercent}%`;
        sliderProgress.style.width = `${maxPercent - minPercent}%`;
      }

      // Helper function to update price displays
      function updateDisplays() {
        minPriceDisplay.textContent = `$${minValue}`;
        maxPriceDisplay.textContent = `$${maxValue}`;
      }
    });
  }
  priceRangeWidget();

  /**
   * Ecommerce Checkout Section
   * This script handles the functionality of both multi-step and one-page checkout processes
   */

  function initCheckout() {
    // Detect checkout type
    const isMultiStepCheckout = document.querySelector('.checkout-steps') !== null;
    const isOnePageCheckout = document.querySelector('.checkout-section') !== null;

    // Initialize common functionality
    initInputMasks();
    initPromoCode();

    // Initialize checkout type specific functionality
    if (isMultiStepCheckout) {
      initMultiStepCheckout();
    }

    if (isOnePageCheckout) {
      initOnePageCheckout();
    }

    // Initialize tooltips (works for both checkout types)
    initTooltips();
  }

  initCheckout();

  // Function to initialize multi-step checkout
  function initMultiStepCheckout() {
    // Get all checkout elements
    const checkoutSteps = document.querySelectorAll('.checkout-steps .step');
    const checkoutForms = document.querySelectorAll('.checkout-form');
    const nextButtons = document.querySelectorAll('.next-step');
    const prevButtons = document.querySelectorAll('.prev-step');
    const editButtons = document.querySelectorAll('.btn-edit');
    const paymentMethods = document.querySelectorAll('.payment-method-header');
    const summaryToggle = document.querySelector('.btn-toggle-summary');
    const orderSummaryContent = document.querySelector('.order-summary-content');

    // Step Navigation
    nextButtons.forEach(button => {
      button.addEventListener('click', function() {
        const nextStep = parseInt(this.getAttribute('data-next'));
        navigateToStep(nextStep);
      });
    });

    prevButtons.forEach(button => {
      button.addEventListener('click', function() {
        const prevStep = parseInt(this.getAttribute('data-prev'));
        navigateToStep(prevStep);
      });
    });

    editButtons.forEach(button => {
      button.addEventListener('click', function() {
        const editStep = parseInt(this.getAttribute('data-edit'));
        navigateToStep(editStep);
      });
    });

    // Payment Method Selection for multi-step checkout
    paymentMethods.forEach(header => {
      header.addEventListener('click', function() {
        // Get the radio input within this header
        const radio = this.querySelector('input[type="radio"]');
        if (radio) {
          radio.checked = true;

          // Update active state for all payment methods
          const allPaymentMethods = document.querySelectorAll('.payment-method');
          allPaymentMethods.forEach(method => {
            method.classList.remove('active');
          });

          // Add active class to the parent payment method
          this.closest('.payment-method').classList.add('active');

          // Show/hide payment method bodies
          const allPaymentBodies = document.querySelectorAll('.payment-method-body');
          allPaymentBodies.forEach(body => {
            body.classList.add('d-none');
          });

          const selectedBody = this.closest('.payment-method').querySelector('.payment-method-body');
          if (selectedBody) {
            selectedBody.classList.remove('d-none');
          }
        }
      });
    });

    // Order Summary Toggle (Mobile)
    if (summaryToggle) {
      summaryToggle.addEventListener('click', function() {
        this.classList.toggle('collapsed');

        if (orderSummaryContent) {
          orderSummaryContent.classList.toggle('d-none');
        }

        // Toggle icon
        const icon = this.querySelector('i');
        if (icon) {
          if (icon.classList.contains('bi-chevron-down')) {
            icon.classList.remove('bi-chevron-down');
            icon.classList.add('bi-chevron-up');
          } else {
            icon.classList.remove('bi-chevron-up');
            icon.classList.add('bi-chevron-down');
          }
        }
      });
    }

    // Form Validation for multi-step checkout
    const forms = document.querySelectorAll('.checkout-form-element');
    forms.forEach(form => {
      form.addEventListener('submit', function(e) {
        e.preventDefault();

        // Basic validation
        const requiredFields = form.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(field => {
          if (!field.value.trim()) {
            isValid = false;
            field.classList.add('is-invalid');
          } else {
            field.classList.remove('is-invalid');
          }
        });

        // If it's the final form and valid, show success message
        if (isValid && form.closest('.checkout-form[data-form="4"]')) {
          // Hide form fields
          const formFields = form.querySelectorAll('.form-group, .review-sections, .form-check, .d-flex');
          formFields.forEach(field => {
            field.style.display = 'none';
          });

          // Show success message
          const successMessage = form.querySelector('.success-message');
          if (successMessage) {
            successMessage.classList.remove('d-none');

            // Add animation
            successMessage.style.animation = 'fadeInUp 0.5s ease forwards';
          }

          // Simulate redirect after 3 seconds
          setTimeout(() => {
            // In a real application, this would redirect to an order confirmation page
            console.log('Redirecting to order confirmation page...');
          }, 3000);
        }
      });
    });

    // Function to navigate between steps
    function navigateToStep(stepNumber) {
      // Update steps
      checkoutSteps.forEach(step => {
        const stepNum = parseInt(step.getAttribute('data-step'));

        if (stepNum < stepNumber) {
          step.classList.add('completed');
          step.classList.remove('active');
        } else if (stepNum === stepNumber) {
          step.classList.add('active');
          step.classList.remove('completed');
        } else {
          step.classList.remove('active', 'completed');
        }
      });

      // Update step connectors
      const connectors = document.querySelectorAll('.step-connector');
      connectors.forEach((connector, index) => {
        if (index + 1 < stepNumber) {
          connector.classList.add('completed');
          connector.classList.remove('active');
        } else if (index + 1 === stepNumber - 1) {
          connector.classList.add('active');
          connector.classList.remove('completed');
        } else {
          connector.classList.remove('active', 'completed');
        }
      });

      // Show the corresponding form
      checkoutForms.forEach(form => {
        const formNum = parseInt(form.getAttribute('data-form'));

        if (formNum === stepNumber) {
          form.classList.add('active');

          // Scroll to top of form on mobile
          if (window.innerWidth < 768) {
            form.scrollIntoView({
              behavior: 'smooth',
              block: 'start'
            });
          }
        } else {
          form.classList.remove('active');
        }
      });
    }
  }

  // Function to initialize one-page checkout
  function initOnePageCheckout() {
    // Payment Method Selection for one-page checkout
    const paymentOptions = document.querySelectorAll('.payment-option input[type="radio"]');

    paymentOptions.forEach(option => {
      option.addEventListener('change', function() {
        // Update active class on payment options
        document.querySelectorAll('.payment-option').forEach(opt => {
          opt.classList.remove('active');
        });

        this.closest('.payment-option').classList.add('active');

        // Show/hide payment details
        const paymentId = this.id;
        document.querySelectorAll('.payment-details').forEach(details => {
          details.classList.add('d-none');
        });

        document.getElementById(`${paymentId}-details`).classList.remove('d-none');
      });
    });

    // Form Validation for one-page checkout
    const checkoutForm = document.querySelector('.checkout-form');

    if (checkoutForm) {
      checkoutForm.addEventListener('submit', function(e) {
        e.preventDefault();

        // Basic validation
        const requiredFields = checkoutForm.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(field => {
          if (!field.value.trim()) {
            isValid = false;
            field.classList.add('is-invalid');

            // Scroll to first invalid field
            if (isValid === false) {
              field.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
              });
              field.focus();
              isValid = null; // Set to null so we only scroll to the first invalid field
            }
          } else {
            field.classList.remove('is-invalid');
          }
        });

        // If form is valid, show success message
        if (isValid === true) {
          // Hide form sections except the last one
          const sections = document.querySelectorAll('.checkout-section');
          sections.forEach((section, index) => {
            if (index < sections.length - 1) {
              section.style.display = 'none';
            }
          });

          // Hide terms checkbox and place order button
          const termsCheck = document.querySelector('.terms-check');
          const placeOrderContainer = document.querySelector('.place-order-container');

          if (termsCheck) termsCheck.style.display = 'none';
          if (placeOrderContainer) placeOrderContainer.style.display = 'none';

          // Show success message
          const successMessage = document.querySelector('.success-message');
          if (successMessage) {
            successMessage.classList.remove('d-none');
            successMessage.style.animation = 'fadeInUp 0.5s ease forwards';
          }

          // Scroll to success message
          const orderReview = document.getElementById('order-review');
          if (orderReview) {
            orderReview.scrollIntoView({
              behavior: 'smooth',
              block: 'start'
            });
          }

          // Simulate redirect after 3 seconds
          setTimeout(() => {
            // In a real application, this would redirect to an order confirmation page
            console.log('Redirecting to order confirmation page...');
          }, 3000);
        }
      });

      // Add input event listeners to clear validation styling when user types
      const formInputs = checkoutForm.querySelectorAll('input, select, textarea');
      formInputs.forEach(input => {
        input.addEventListener('input', function() {
          if (this.value.trim()) {
            this.classList.remove('is-invalid');
          }
        });
      });
    }
  }

  // Function to initialize input masks (common for both checkout types)
  function initInputMasks() {
    // Card number input mask (format: XXXX XXXX XXXX XXXX)
    const cardNumberInput = document.getElementById('card-number');
    if (cardNumberInput) {
      cardNumberInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 16) value = value.slice(0, 16);

        // Add spaces after every 4 digits
        let formattedValue = '';
        for (let i = 0; i < value.length; i++) {
          if (i > 0 && i % 4 === 0) {
            formattedValue += ' ';
          }
          formattedValue += value[i];
        }

        e.target.value = formattedValue;
      });
    }

    // Expiry date input mask (format: MM/YY)
    const expiryInput = document.getElementById('expiry');
    if (expiryInput) {
      expiryInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 4) value = value.slice(0, 4);

        // Format as MM/YY
        if (value.length > 2) {
          value = value.slice(0, 2) + '/' + value.slice(2);
        }

        e.target.value = value;
      });
    }

    // CVV input mask (3-4 digits)
    const cvvInput = document.getElementById('cvv');
    if (cvvInput) {
      cvvInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 4) value = value.slice(0, 4);
        e.target.value = value;
      });
    }

    // Phone number input mask
    const phoneInput = document.getElementById('phone');
    if (phoneInput) {
      phoneInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 10) value = value.slice(0, 10);

        // Format as (XXX) XXX-XXXX
        if (value.length > 0) {
          if (value.length <= 3) {
            value = '(' + value;
          } else if (value.length <= 6) {
            value = '(' + value.slice(0, 3) + ') ' + value.slice(3);
          } else {
            value = '(' + value.slice(0, 3) + ') ' + value.slice(3, 6) + '-' + value.slice(6);
          }
        }

        e.target.value = value;
      });
    }

    // ZIP code input mask (5 digits)
    const zipInput = document.getElementById('zip');
    if (zipInput) {
      zipInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 5) value = value.slice(0, 5);
        e.target.value = value;
      });
    }
  }

  // Function to handle promo code application (common for both checkout types)
  function initPromoCode() {
    const promoInput = document.querySelector('.promo-code input');
    const promoButton = document.querySelector('.promo-code button');

    if (promoInput && promoButton) {
      promoButton.addEventListener('click', function() {
        const promoCode = promoInput.value.trim();

        if (promoCode) {
          // Simulate promo code validation
          // In a real application, this would make an API call to validate the code

          // For demo purposes, let's assume "DISCOUNT20" is a valid code
          if (promoCode.toUpperCase() === 'DISCOUNT20') {
            // Show success state
            promoInput.classList.add('is-valid');
            promoInput.classList.remove('is-invalid');
            promoButton.textContent = 'Applied';
            promoButton.disabled = true;

            // Update order total (in a real app, this would recalculate based on the discount)
            const orderTotal = document.querySelector('.order-total span:last-child');
            const btnPrice = document.querySelector('.btn-price');

            if (orderTotal) {
              // Apply a 20% discount
              const currentTotal = parseFloat(orderTotal.textContent.replace('$', ''));
              const discountedTotal = (currentTotal * 0.8).toFixed(2);
              orderTotal.textContent = '$' + discountedTotal;

              // Update button price if it exists
              if (btnPrice) {
                btnPrice.textContent = '$' + discountedTotal;
              }

              // Add discount line
              const orderTotals = document.querySelector('.order-totals');
              if (orderTotals) {
                const discountElement = document.createElement('div');
                discountElement.className = 'order-discount d-flex justify-content-between';
                discountElement.innerHTML = `
                <span>Discount (20%)</span>
                <span>-$${(currentTotal * 0.2).toFixed(2)}</span>
              `;

                // Insert before the total
                const totalElement = document.querySelector('.order-total');
                if (totalElement) {
                  orderTotals.insertBefore(discountElement, totalElement);
                }
              }
            }
          } else {
            // Show error state
            promoInput.classList.add('is-invalid');
            promoInput.classList.remove('is-valid');

            // Reset after 3 seconds
            setTimeout(() => {
              promoInput.classList.remove('is-invalid');
            }, 3000);
          }
        }
      });
    }
  }

  // Function to initialize Bootstrap tooltips
  function initTooltips() {
    // Check if Bootstrap's tooltip function exists
    if (typeof bootstrap !== 'undefined' && typeof bootstrap.Tooltip !== 'undefined') {
      const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
      const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
    } else {
      // Fallback for when Bootstrap JS is not loaded
      const cvvHint = document.querySelector('.cvv-hint');
      if (cvvHint) {
        cvvHint.addEventListener('mouseenter', function() {
          this.setAttribute('data-original-title', this.getAttribute('title'));
          this.setAttribute('title', '');
        });

        cvvHint.addEventListener('mouseleave', function() {
          this.setAttribute('title', this.getAttribute('data-original-title'));
        });
      }
    }
  }

  /**
   * Initiate glightbox
   */
  const glightbox = GLightbox({
    selector: '.glightbox'
  });

  /**
   * Initiate Pure Counter
   */
  new PureCounter();

  /**
   * Frequently Asked Questions Toggle
   */
  document.querySelectorAll('.faq-item h3, .faq-item .faq-toggle').forEach((faqItem) => {
    faqItem.addEventListener('click', () => {
      faqItem.parentNode.classList.toggle('faq-active');
    });
  });

})();

//password


 function togglePasswordVisibility(fieldId) {
  const passwordField = document.getElementById(fieldId);
  const parent = passwordField.parentElement; // input-group
  const icon = parent.querySelector('i'); // icon inside the same input-group
  if (passwordField.type === 'password') {
    passwordField.type = 'text';
    icon.classList.remove('bi-eye');
    icon.classList.add('bi-eye-slash');
  } else {
    passwordField.type = 'password';
    icon.classList.remove('bi-eye-slash');
    icon.classList.add('bi-eye');
  }
}
(function initRegistrationFormSwitcher() {
  // Helper to set required on all inputs/selects/textareas in a section
  function setSectionRequired(section, required) {
    if (!section) return;
    section.querySelectorAll('input, select, textarea').forEach(el => {
      if (required) {
        el.setAttribute('required', 'required');
      } else {
        el.removeAttribute('required');
      }
    });
  }


  document.addEventListener('DOMContentLoaded', function() {
    var supportDocRadios = document.querySelectorAll('input[name="supportDocRadio"]');
    var mainFileRadios = document.querySelectorAll('input[name="btnradio"]');
    var priceSpanTop = document.getElementById('mainProductPriceTop');
    var defaultPrice = document.getElementById('defaultPrice').value;
    var basePrice = parseFloat(document.getElementById('basePrice').value);
    var loyaltyBadges = document.querySelectorAll('.loyalty-badge');

    function updateLoyaltyPrices(newBasePrice) {
        loyaltyBadges.forEach(function(badge) {
            var discount = parseFloat(badge.getAttribute('data-discount'));
            var discounted = newBasePrice - (newBasePrice * (discount / 100));
            var priceSpan = badge.querySelector('.loyalty-price');
            if (priceSpan) {
                priceSpan.textContent = discounted.toLocaleString(undefined, {minimumFractionDigits:2});
            }
        });
    }

    // Helper to deselect all main file radios
    function deselectMainFileRadios() {
        mainFileRadios.forEach(function(radio) {
            radio.checked = false;
        });
    }

    // Listen for support doc radio changes
    supportDocRadios.forEach(function(radio) {
        radio.addEventListener('change', function() {
            if (radio.checked) {
                deselectMainFileRadios();
                var price = parseFloat(radio.getAttribute('data-price'));
                priceSpanTop.textContent = price.toLocaleString(undefined, {minimumFractionDigits:2});
                updateLoyaltyPrices(price);
            }
        });
    });

    // Listen for main file radio changes
    mainFileRadios.forEach(function(radio) {
        radio.addEventListener('change', function() {
            if (radio.checked) {
                supportDocRadios.forEach(function(supportRadio) {
                    supportRadio.checked = false;
                });
                priceSpanTop.textContent = defaultPrice;
                updateLoyaltyPrices(basePrice);
            }
        });
    });

    // Set initial loyalty prices on page load
    updateLoyaltyPrices(basePrice);
});

  // Isolated function to handle selection and show appropriate form
  function continueWithSelection() {
    const selectedType = document.getElementById('registrationType')?.value;
    if (!selectedType) {
      alert("Please select a registration type.");
      return;
    }
    const url = new URL(window.location.href);
    url.searchParams.set('type', selectedType);
    window.history.replaceState(null, '', url);
    showForm(selectedType);
  }

  // Show only the relevant form section and set required attributes
  function showForm(type) {
    const typeSelector = document.getElementById('typeSelector');
    const individualSection = document.getElementById('individualSection');
    const companySection = document.getElementById('companySection');
    const sharedSection = document.getElementById('sharedSection');

    if (typeSelector) typeSelector.style.display = 'none';
    if (individualSection) individualSection.style.display = 'none';
    if (companySection) companySection.style.display = 'none';

    // Remove required from both sections first
    setSectionRequired(individualSection, false);
    setSectionRequired(companySection, false);

    if (type === 'individual' && individualSection) {
      individualSection.style.display = 'block';
      setSectionRequired(individualSection, true);
    } else if (type === 'company' && companySection) {
      companySection.style.display = 'block';
      setSectionRequired(companySection, true);
    }

    if (sharedSection) sharedSection.style.display = 'block';
    // Optionally, always set required for sharedSection fields if needed
    // setSectionRequired(sharedSection, true);
  }




  // DOM ready check to initialize everything
  document.addEventListener('DOMContentLoaded', function () {
    const urlParams = new URLSearchParams(window.location.search);
    const type = urlParams.get('type');

    if (type === 'individual' || type === 'company') {
      showForm(type);
    } else {
      const typeSelector = document.getElementById('typeSelector');
      if (typeSelector) typeSelector.style.display = 'block';
    }

    // Attach only the necessary function globally
    window.continueWithSelection = continueWithSelection;
  });
})();


//function for read more or see less
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.product-short-description').forEach(function (container) {
        const readMoreBtn = container.querySelector('.read-more-btn');
        const readLessBtn = container.querySelector('.read-less-btn');
        const shortDesc = container.querySelector('.short-description');
        const fullDesc = container.querySelector('.full-description');

        if (readMoreBtn && readLessBtn && shortDesc && fullDesc) {
            readMoreBtn.addEventListener('click', function () {
                shortDesc.style.display = 'none';
                fullDesc.style.display = 'inline';
                readMoreBtn.style.display = 'none';
                readLessBtn.style.display = 'inline';
            });

            readLessBtn.addEventListener('click', function () {
                shortDesc.style.display = 'inline';
                fullDesc.style.display = 'none';
                readMoreBtn.style.display = 'inline';
                readLessBtn.style.display = 'none';
            });
        }
    });
});

document.querySelectorAll('.deletefile').forEach(button => {
  button.addEventListener('click', function() {
      if (confirm('Are you sure you want to delete this file?')) {
          let imageId = this.getAttribute('data-file-id');
          fetch(`delete_image.php?action=deletefile&image_id=${imageId}`, {
              method: 'GET'
          })
          .then(response => response.json())
          .then(data => {
              if (data.success) {
                  this.closest('.file-preview').remove();
                  showToast('File deleted successfully.');
              } else {
                  alert('Failed to delete file.');
              }
          })
          .catch(error => {
              console.error('Error deleting file:', error);
          });
      }
  });
});

document.querySelectorAll('.delete-guidance-video').forEach(button => {
  button.addEventListener('click', function() {
      if (confirm('Are you sure you want to delete this file?')) {
          let imageId = this.getAttribute('data-image-id');
          fetch(`delete_image.php?action=deleteguidancevideo&image_id=${imageId}`, {
              method: 'GET'
          })
          .then(response => response.json())
          .then(data => {
              if (data.success) {
                  this.closest('.file-preview').remove();
                  showToast('File deleted successfully.');
              } else {
                  alert('Failed to delete file.');
              }
          })
          .catch(error => {
              console.error('Error deleting file:', error);
          });
      }
  });
});

document.querySelectorAll('.delete-image').forEach(button => {
  button.addEventListener('click', function() {
      if (confirm('Are you sure you want to delete this image?')) {
          let imageId = this.getAttribute('data-image-id');
          fetch(`delete_image?action=deleteimage&image_id=${imageId}`, {
              method: 'GET'
          })
          .then(response => response.json())
          .then(data => {
              if (data.success) {
                  this.closest('.image-preview').remove();
                  showToast('Image deleted successfully.');
              } else {
                  alert('Failed to delete image.');
              }
          })
          .catch(error => {
              console.error('Error deleting image:', error);
          });
      }
  });
});
    document.addEventListener("DOMContentLoaded", function () {
        const paystackButton = document.querySelector(".paystack-button");
        const manualButton = document.querySelector(".manual-button");
        const paymentMethods = document.querySelectorAll("input[name='payment_method']");

        paymentMethods.forEach(method => {
            method.addEventListener("change", function () {
                if (this.value === "paystack") {
                    paystackButton.style.display = "block";
                    manualButton.style.display = "none";
                } else if (this.value === "manual") {
                    paystackButton.style.display = "none";
                    manualButton.style.display = "block";
                }
            });
        });
    });

function updateCartCount(count) {
  const cartCountElement = document.querySelector('.cart-count');
  if (cartCountElement) {
    cartCountElement.textContent = count;
  }
}

function updateWishlistCount(count) {
  const wishlistCountElement = document.querySelector('.wishlist-count');
  if (wishlistCountElement) {
    wishlistCountElement.textContent = count;
  }
}



function showToast(message) {
  const toastContainer = document.createElement('div');
  toastContainer.className = 'toast-container position-fixed bottom-0 end-0 p-3';
  toastContainer.style.zIndex = 11;

  const toast = document.createElement('div');
  toast.id = 'liveToast';
  toast.className = 'toast align-items-center text-white bg-primary border-0';
  toast.role = 'alert';
  toast.ariaLive = 'assertive';
  toast.ariaAtomic = 'true';

  const toastBody = document.createElement('div');
  toastBody.className = 'toast-body';
  toastBody.textContent = message;

  const toastButton = document.createElement('button');
  toastButton.type = 'button';
  toastButton.className = 'btn-close btn-close-white me-2 m-auto';
  toastButton.setAttribute('data-bs-dismiss', 'toast');
  toastButton.ariaLabel = 'Close';

  const toastFlex = document.createElement('div');
  toastFlex.className = 'd-flex';
  toastFlex.appendChild(toastBody);
  toastFlex.appendChild(toastButton);

  toast.appendChild(toastFlex);
  toastContainer.appendChild(toast);
  document.body.appendChild(toastContainer);

  const bootstrapToast = new bootstrap.Toast(toast, { delay: 5000 });
  bootstrapToast.show();
}
$(document).ready(function() {
  $('.select-multiple').select2({
    placeholder: "Select options"
  });
});
//add to wishlist icon 
$('.btn-wishlist').click(function(e) {
    e.preventDefault();

    var button = $(this);
    var productId = button.data('product-id');
    var userId = $('#user_id').val();
    var siteurl = $('#siteurl').val();

    if (!userId) {
        window.location.href = siteurl +'login';
        return;
    }
    $.ajax({
        url: siteurl +'addwishlist',
        type: 'POST',
        data: {
            productId: productId,
            user: userId,
        },
        success: function(response) {
            if (response.trim() === 'success') {
                button.addClass('added');
                button.find('i').css('color', 'red'); // Change icon to red
                showToast('Item added to wishlist');
            } else if (response.trim() === 'removed') {
                button.removeClass('added');
                button.find('i').css('color', ''); // Reset to default
                showToast('Item removed from wishlist');
            } else if (response.trim() === 'redirect') {
                window.location.href = siteurl +'login';
            } else {
                showToast('Failed to update wishlist');
            }
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
            alert('An error occurred. Please try again.');
        }
    });
});


$(document).on('click', '.remove-item', function () {
    const itemId = $(this).data('item-id');
    const siteUrl = $('#siteurl').val();

    if (confirm('Are you sure you want to remove this item?')) {
        $.ajax({
            url: siteUrl + 'delete_cart_item',
            type: 'POST',
            data: { item_id: itemId },
            success: function (response) {
                try {
                    const data = JSON.parse(response);

                    if (data.success) {
                        // Remove the item from the DOM
                        $('#cart-item-' + itemId).remove();

                        // Update cart count and total
                        updateCartCount(data.cartCount);
                        $('.cart-total').text(data.total);

                        // Reload if the cart is now empty
                        if (parseInt(data.cartCount) === 0) {
                            window.location.reload();
                        }

                        showToast('Item deleted from cart successfully');
                    } else {
                        showToast('Error removing item');
                    }
                } catch (e) {
                    console.error('Invalid JSON response:', response);
                    showToast('An unexpected error occurred.');
                }
            },
            error: function () {
                showToast('Failed to communicate with the server.');
            }
        });
    }
});


// Add to wishlist functionality for product detail page
$('.wishlist-btn').click(function(e) {
    e.preventDefault();

    var button = $(this);
    var productId = button.data('product-id');
    var userId = $('#user_id').val();
    var siteurl = $('#siteurl').val();

    if (!userId) {
        window.location.href = siteurl +'login';
        return;
    }
    $.ajax({
        url: siteurl +'addwishlist',
        type: 'POST',
        data: {
            productId: productId,
            user: userId,
        },
        success: function(response) {
            if (response.trim() === 'success') {
                button.addClass('added');
                button.find('i').css('color', 'red'); // Change icon to red
                showToast('Item added to wishlist');
            } else if (response.trim() === 'removed') {
                button.removeClass('added');
                button.find('i').css('color', ''); // Reset to default
                showToast('Item removed from wishlist');
            } else if (response.trim() === 'redirect') {
                window.location.href = siteurl +'login';
            } else {
                showToast('Failed to update wishlist');
            }
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
            alert('An error occurred. Please try again.');
        }
    });
});




$(document).ready(function(){
  $("#addCart").click(function(){
      var fileId = $('input[name="btnradio"]:checked').val() || null;
      var supportDocId = $('input[name="supportDocRadio"]:checked').val() || null;
      var supportDocPrice = $('input[name="supportDocRadio"]:checked').attr('data-price') || null;
      var report_id = $('#current_report_id').val();
      var user_id = $('#user_id').val();
      var order_id = $('#order_id').val();
      var affliate_id = $('#affliate_id').val();
      var siteurl = $('#siteurl').val();

      // Redirect if the user is not logged in
      if (!user_id) {
          window.location.href = siteurl +'login';
          return;
      }

      // Require at least one selection
      if (!fileId && !supportDocId) {
          showToast('Please select a file format or support document.');
          return;
      }

      var data = {
          reportId: report_id,
          userId: user_id,
          orderId: order_id,
          affliateId: affliate_id,
          file_id: fileId,
          support_doc_id: supportDocId,
          support_doc_price: supportDocPrice
      };

      $.ajax({
          url: siteurl +'add_to_cart',
          type: 'POST',
          data: data,
          success: function(response){
              let data = typeof response === 'string' ? JSON.parse(response) : response;
              if (data.error) {
                  showToast(data.error);
              } else {
                  showToast('Item added to cart successfully');
              }
              if (data.cartCount) {
                  updateCartCount(data.cartCount);
              }
          },
          error: function(){
              showToast('Error adding to cart');
          }
      });
  });
});

function toggleReplies(commentId) {
  var replies = document.getElementById('replies-' + commentId);
  if (replies.style.display === 'none') {
    replies.style.display = 'block';
  } else {
    replies.style.display = 'none';
  }
}
function showReplyForm(commentId) {
  var form = document.getElementById('reply-form-' + commentId);
  if (form.style.display === 'none') {
    form.style.display = 'block';
  } else {
    form.style.display = 'none';
  }
}
document.getElementById('webShareBtn').addEventListener('click', function() {
  if (navigator.share) {
    navigator.share({
      title: "<?php echo addslashes($current_title); ?>",
      text: "<?php echo addslashes($current_title); ?>",
      url: "<?php echo $siteurl . 'view-blog.php/' . $raw_slug; ?>"
    });
  } else {
    alert('Sharing is not supported in this browser. Please use the social icons.');
  }
});



document.getElementById('documentSelect').addEventListener('change', function() {
  console.log('Document select changed');
  const selectedOptions = Array.from(this.selectedOptions).map(option => option.value);
  console.log('Selected options:', selectedOptions);
  const pageInputsDiv = document.getElementById('pageInputs');

  // Loop through existing inputs and remove the ones for deselected options
  Array.from(pageInputsDiv.children).forEach(child => {
    const inputName = child.getAttribute('data-doc-type');
    console.log('Checking input:', inputName);
    if (!selectedOptions.includes(inputName)) {
      console.log('Removing input for:', inputName);
      child.remove();
    }
  });

  // Add inputs for newly selected options
  selectedOptions.forEach(docType => {
    console.log('Processing doc type:', docType);
    if (!document.querySelector(`[data-doc-type="${docType}"]`)) {
      console.log('Creating new input group for:', docType);
      const inputGroup = document.createElement('div');
      inputGroup.className = 'input-group mb-3';
      inputGroup.setAttribute('data-doc-type', docType);

      const fileLabel = document.createElement('span');
      fileLabel.className = 'input-group-text';
      fileLabel.textContent = `Upload ${docType}:`;

      const fileInput = document.createElement('input');
      fileInput.type = 'file';
      fileInput.className = 'form-control';
      fileInput.name = `file_${docType}`;
      fileInput.accept = getAcceptedFormats(docType);

      const pageLabel = document.createElement('span');
      pageLabel.className = 'input-group-text';
      pageLabel.textContent = `Pages for ${docType}:`;

      const pageInput = document.createElement('input');
      pageInput.type = 'number';
      pageInput.className = 'form-control';
      pageInput.min = '1';
      pageInput.name = `pages_${docType}`;
      pageInput.required = true;

      inputGroup.appendChild(fileLabel);
      inputGroup.appendChild(fileInput);
      inputGroup.appendChild(pageLabel);
      inputGroup.appendChild(pageInput);
      pageInputsDiv.appendChild(inputGroup);
    }
  });
});

function handleDocumentSelect(selectElement) {
  console.log('Document select changed');
  const selectedOptions = Array.from(selectElement.selectedOptions).map(option => option.value);
  console.log('Selected options:', selectedOptions);
  const pageInputsDiv = document.getElementById('pageInputs');

  // Loop through existing inputs and remove the ones for deselected options
  Array.from(pageInputsDiv.children).forEach(child => {
      const inputName = child.getAttribute('data-doc-type');
      if (!selectedOptions.includes(inputName)) {
          child.remove();
      }
  });

  // Add inputs for newly selected options
  selectedOptions.forEach(docType => {
      if (!document.querySelector(`[data-doc-type="${docType}"]`)) {
          // Create container div
          const inputContainer = document.createElement('div');
          inputContainer.className = 'mb-3';
          inputContainer.setAttribute('data-doc-type', docType);

          // Create label and file input
          const fileLabel = document.createElement('label');
          fileLabel.className = 'form-label';
          fileLabel.textContent = `Upload ${docType}:`;

          const fileInput = document.createElement('input');
          fileInput.type = 'file';
          fileInput.className = 'form-control';
          fileInput.name = `file_${docType}`;
          fileInput.accept = getAcceptedFormats(docType);

          // Create label and page input
          const pageLabel = document.createElement('label');
          pageLabel.className = 'form-label mt-2';
          pageLabel.textContent = `Number of Pages for ${docType}:`;

          const pageInput = document.createElement('input');
          pageInput.type = 'number';
          pageInput.className = 'form-control';
          pageInput.min = '1';
          pageInput.name = `pages_${docType}`;
          pageInput.required = true;

          // Append elements
          inputContainer.appendChild(fileLabel);
          inputContainer.appendChild(fileInput);
          inputContainer.appendChild(pageLabel);
          inputContainer.appendChild(pageInput);
          pageInputsDiv.appendChild(inputContainer);
      }
  });
}


// Function to return accepted file formats
function getAcceptedFormats(docType) {
    const formats = {
        word: ".doc,.docx",
        excel: ".xls,.xlsx",
        googleSheets: ".xlsx,.csv,.tsv,.ods,.pdf",
        powerpoint: ".ppt,.pptx",
        pdf: ".pdf",
        text: ".txt",
        zip: ".zip,.rar,.tgz,.tar,.gz",
    };
    return formats[docType] || "*";
}


 
function togglePast() {
  const pricingType = document.getElementById('resourceType');
  const priceField = document.getElementById('past-field');

  // Convert selected options to array of values
  const selectedValues = Array.from(pricingType.selectedOptions).map(opt => opt.value);

  // Check if '19' is one of the selected values
  if (selectedValues.includes('19')) {
    priceField.style.display = 'block';
  } else {
    priceField.style.display = 'none';
  }
}

function togglePrice() {
  const pricingType = document.getElementById('pricing-type');
  const priceField = document.getElementById('price-field');
  priceField.style.display = pricingType.value === 'paid' ? 'block' : 'none';
}



function handleGuidanceSelect(select) {
  // Hide both fields and remove required attribute
  document.getElementById('methodologyBox').style.display = 'none';
  document.getElementById('videoBox').style.display = 'none';
  document.getElementById('basic-default-message').required = false;
  document.getElementById('guidanceVideo').required = false;

  if (select.value === 'methodology') {
    document.getElementById('methodologyBox').style.display = 'block';
    document.getElementById('basic-default-message').required = true;
  } else if (select.value === 'video') {
    document.getElementById('videoBox').style.display = 'block';
    document.getElementById('guidanceVideo').required = true;
  }
}

function handleSupportDocSelect(select) {
  const selected = Array.from(select.selectedOptions).map(opt => opt.value);

  document.querySelectorAll('.supportDocFileInput').forEach(div => {
    div.style.display = 'none';
    const fileInput = div.querySelector('input[type="file"]');
    const priceInput = div.querySelector('input[type="number"]');
    if (fileInput) fileInput.required = false;
    if (priceInput) priceInput.required = false;
  });

  selected.forEach(key => {
    const inputDiv = document.getElementById('fileInput_' + key);
    if (inputDiv) {
      inputDiv.style.display = 'block';
      const fileInput = inputDiv.querySelector('input[type="file"]');
      const priceInput = inputDiv.querySelector('input[type="number"]');
      // Only require file if there is NO existing file link
      const hasExistingFile = !!inputDiv.querySelector('a.btn-outline-secondary');
      if (fileInput) fileInput.required = !hasExistingFile;
      if (priceInput) priceInput.required = true;
    }
  });
}





