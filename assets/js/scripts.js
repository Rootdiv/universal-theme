//Плавная прокрутка страницы вверх
window.addEventListener('scroll', function () {
  let scrollHeight = Math.round(window.scrollY);
  if (scrollHeight < 300) document.querySelector('.go-top').style.opacity = '0'
  else document.getElementsByClassName('go-top')[0].style.opacity = '1'
});
document.querySelector('.go-top').addEventListener('click', function () {
  backToTop();
});

function backToTop() {
  if (window.pageYOffset > 0) {
    window.scrollBy(0, -10);
    setTimeout(backToTop, 0);
  }
}

var mySwiper = new Swiper('.swiper-container', {
  // Optional parameters
  loop: true,

  autoplay: {
    delay: 5000,
  },

  // If we need pagination
  pagination: {
    el: '.swiper-pagination',
  },
})

let menuToggle = $('.header-menu-toggle');
menuToggle.on('click', function (event) {
  event.preventDefault();
  $('.header-nav').slideToggle(200);
});

let contactsForm = $('.contacts-form');

contactsForm.on('submit', function (event) {
  event.preventDefault();
  //let formData = new FormData(this);
  let formData = new FormData();
  formData.append('action', 'contacts_form');
  $.ajax({
    type: "POST",
    url: adminAjax.url,
    data: formData,
    contentType: false,
    processData: false,
    success: function (response) {
      console.log('Ответ сервера: ' + response);
    }
  });
})
