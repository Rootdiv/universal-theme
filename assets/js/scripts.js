'use strict';

//Плавная прокрутка страницы вверх
const arrowTop = document.querySelector('.go-top');
if (arrowTop) {
  window.addEventListener('scroll', function() {
    const scrollHeight = Math.round(window.scrollY);
    if (scrollHeight < 300) {
      arrowTop.style.opacity = '0';
    } else {
      arrowTop.style.opacity = '1';
    }
  });

  function backToTop() {
    if (window.pageYOffset > 0) {
      window.scrollBy(0, -10);
      setTimeout(backToTop, 0);
    }
  }
  arrowTop.addEventListener('click', function() {
    backToTop();
  });
}

const mySwiper = new Swiper('.swiper-container', {
  // Optional parameters
  loop: true,

  autoplay: {
    delay: 5000,
  },

  // If we need pagination
  pagination: {
    el: '.swiper-pagination',
  },
});

jQuery(function($) {
  const menuToggle = $('.header-menu-toggle');
  menuToggle.on('click', function(event) {
    event.preventDefault();
    $('.header-nav').slideToggle(200);
  });

  const contactsForm = $('.contacts-form');

  contactsForm.on('submit', function(event) {
    event.preventDefault();
    let formData = new FormData(this);
    formData.append('action', 'contacts_form');
    $.ajax({
      type: 'POST',
      url: adminAjax.url, //jshint ignore:line
      data: formData,
      contentType: false,
      processData: false,
      success: function(response) {
        console.log('Ответ сервера: ' + response);
      },
    });
  });
});
