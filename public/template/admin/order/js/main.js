/*
 * show pass
 * image select
 * otp input
 * check radio
 * range slider
 * btnQuantity
 * press heart
 * Clear all
 * Clear Item History
 * Clear Checkbox
 * Suggestions
 * active Suggestions
 * fixed body popup
 * back Page
 * click sidebar
 * preloader
 */
(function ($) {
  "use strict";

  /* show pass
  ------------------------------------------------------------------------------------- */
  var showPass = function () {
    $(".show-pass").on("click", function () {
      $(this).toggleClass("active");
      if ($(".password-field").attr("type") == "password") {
        $(".password-field").attr("type", "text");
      } else if ($(".password-field").attr("type") == "text") {
        $(".password-field").attr("type", "password");
      }
    });
    $(".show-pass2").on("click", function () {
      $(this).toggleClass("active");
      if ($(".password-field2").attr("type") == "password") {
        $(".password-field2").attr("type", "text");
      } else if ($(".password-field2").attr("type") == "text") {
        $(".password-field2").attr("type", "password");
      }
    });
  };
  /* image select
  ------------------------------------------------------------------------------------- */
  var selectImages = function () {
    if ($(".image-select").length > 0) {
      const selectIMG = $(".image-select");
      selectIMG.find("option").each((idx, elem) => {
        const selectOption = $(elem);
        const imgURL = selectOption.attr("data-thumbnail");
        if (imgURL) {
          selectOption.attr(
            "data-content",
            "<img src='%i'/> %s"
              .replace(/%i/, imgURL)
              .replace(/%s/, selectOption.text())
          );
        }
      });
      selectIMG.selectpicker();
    }
  };
  /* otp input
  ------------------------------------------------------------------------------------- */
  var otpInput = function () {
    if ($(".digit-group").length > 0) {
      $(".digit-group")
        .find("input")
        .each(function () {
          $(this).attr("maxlength", 1);
          $(this).on("keyup", function (e) {
            var parent = $($(this).parent());

            if (e.keyCode === 8 || e.keyCode === 37) {
              var prev = parent.find("input#" + $(this).data("previous"));

              if (prev.length) {
                $(prev).select();
              }
            } else if (
              (e.keyCode >= 48 && e.keyCode <= 57) ||
              (e.keyCode >= 65 && e.keyCode <= 90) ||
              (e.keyCode >= 96 && e.keyCode <= 105) ||
              e.keyCode === 39
            ) {
              var next = parent.find("input#" + $(this).data("next"));

              if (next.length) {
                $(next).select();
              } else {
                if (parent.data("autosubmit")) {
                  parent.submit();
                }
              }
            }
          });
        });
    }
  };
  /* check radio
  ------------------------------------------------------------------------------------- */
  var checkRadio = function () {
    $(".check-ip-bg:checked").parent().addClass("check");
    $(".check-ip-bg").on("click", function () {
      $(".check-ip-bg:not(:checked)").parent().removeClass("check");
      $(".check-ip-bg:checked").parent().addClass("check");
    });
  };

  /* range slider
  ------------------------------------------------------------------------------------- */
  var rangeSlider = function () {
    if ($("#range-two-val").length > 0) {
      var rangeTwoSlider = document.getElementById("range-two-val");
      noUiSlider.create(rangeTwoSlider, {
        start: [17, 128],
        connect: true,
        tooltips: [true, true],
        range: {
          min: 0,
          max: 160,
        },
        format: {
          to: (v) => v | 0,
          from: (v) => v | 0,
        },
      });
    }
  };
  /* btnQuantity
  ------------------------------------------------------------------------------------- */
  var btnQuantity = function () {
    $(".minus-btn").on("click", function (e) {
      e.preventDefault();
      var $this = $(this);
      var $input = $this.closest("div").find("input");
      var value = parseInt($input.val());

      if (value > 1) {
        value = value - 1;
      }

      $input.val(value);
    });
    $(".plus-btn").on("click", function (e) {
      e.preventDefault();
      var $this = $(this);
      var $input = $this.closest("div").find("input");
      var value = parseInt($input.val());

      if (value > 0) {
        value = value + 1;
      }

      $input.val(value);
    });
  };
  /* press heart
  ------------------------------------------------------------------------------------- */
  var pressHeart = function () {
    $(".heart").on("click", function () {
      $(this).toggleClass("active");
    });
  };
  /* Clear all
  ------------------------------------------------------------------------------------- */
  var clearAll = function () {
    $(".clear-all").on("click", function () {
      $(".history").css("display", "none");
    });
  };
  /* Clear Item History
  ------------------------------------------------------------------------------------- */
  var clearItem = function () {
    $(".item-history").each(function (e) {
      var el = this.querySelector(".clear-item");
      el.addEventListener("click", function () {
        el.closest(".item-history").style.display = "none";
      });
    });
  };
  /* Clear Checkbox 
  ------------------------------------------------------------------------------------- */
  var clearCheckbox = function () {
    $(".clear-checkbox").on("click", function () {
      $(".group-checkbox").find("input").prop("checked", false);
    });

    $(".clear-checkbox").on("click", function (e) {
      e.preventDefault();
    });
  };

  /* Suggestions
  ------------------------------------------------------------------------------------- */
  var Suggest = function () {
    $(".suggest").on("click", function () {
      var val = $(this).text();
      $(".suggest_value").val(val);
    });
  };
  /* active Suggestions
  ------------------------------------------------------------------------------------- */
  var activeSuggest = function () {
    $(".rate-suggest").click(function () {
      $(".rate-suggest.active").removeClass("active");
      $(this).addClass("active");
    });
  };
  /* fixed body popup
  ------------------------------------------------------------------------------------- */
  var fixedBody = function () {
    $(".btn-sidebar").on("click", function () {
      $("body").addClass("fixed-body");
    });
    $(".clear-fixed").on("click", function () {
      $("body").removeClass("fixed-body");
    });
  };
  /* back Page
  ------------------------------------------------------------------------------------- */
  var backPage = function () {
    $(".back-btn").on("click", function (e) {
      e.stopPropagation();
      e.preventDefault();
      window.history.go(-1);
    });
  };
  /* click sidebar
  ------------------------------------------------------------------------------------- */
  const clickSideBar = function () {
    const modalNav = $(".menu-mobile-popup");
    if (modalNav.length) {
      const open = function () {
        modalNav.addClass("modal-menu--open");
      };
      const close = function () {
        modalNav.removeClass("modal-menu--open");
      };
      // open();
      $(".btn-sidebar, .btn-st2").on("click", function () {
        open();
      });
      $(".modal-menu__backdrop").on("click", function () {
        close();
      });
    }
  };
  /* clear Text
  ------------------------------------------------------------------------------------- */
  const clearText = function () {
    $(".icon-close").on("click", function () {
      $(".ip-field").val("");
    });
  };
  /* preloader
  ------------------------------------------------------------------------------------- */
  const preloaderIndex = function () {
    setTimeout(function () {
      $(".preloadIndex").fadeOut("slow", function () {
        $(this).remove();
      });
    }, 150);
  };

  /* preloader 2
  ------------------------------------------------------------------------------------- */
  const preloader = function () {
    setTimeout(function () {
      $(".preload").fadeOut("slow", function () {
        $(this).remove();
      });
    }, 100);
  };

  $(function () {
    showPass();
    selectImages();
    otpInput();
    checkRadio();
    rangeSlider();
    btnQuantity();
    pressHeart();
    clearAll();
    clearItem();
    clearCheckbox();
    Suggest();
    backPage();
    clearText();
    clickSideBar();
    activeSuggest();
    fixedBody();
    preloaderIndex();
    preloader();
  });
})(jQuery);




// forEach(btn_add =>{
//   btn_add.onclick = () =>{
//     preveiwContainer.style.display = 'flex';
//     let name = btn_add.getAttribute('data-name');
//     previewBox.forEach(preview =>{
//       let target = preview.getAttribute('data-target');
//       if(name == target){
//         preview.classList.add('active');
//       }
//     });
//   };
// });
function openQuickView(event){
let name = event.getAttribute('data-name'); 
let preveiwContainer = document.querySelectorAll('.products-preview');
let previewBox = document.querySelectorAll('.preview');
    preveiwContainer.forEach(con => {
      if(con.getAttribute('data-target') == name){
        con.style.display = 'flex';
        return;
      }
    });  
    previewBox.forEach(preview =>{
      let target = preview.getAttribute('data-target');
      if(name == target){
        preview.classList.add('active');
        return;
      }
    });

}

function closeQuickView(event){
  let name = event.getAttribute('data-name'); 
  let preveiwContainer = document.querySelectorAll('.products-preview');
  let previewBox = document.querySelectorAll('.preview');
  preveiwContainer.forEach(con => {
    if(con.getAttribute('data-target') == name){
      con.style.display = 'none';
      return;
    }
  });  
  previewBox.forEach(preview =>{
    let target = preview.getAttribute('data-target');
    if(name == target){
      preview.classList.remove('active');
      return;
    }
  });
}
function increaseCount(a, b) {
  var input = b.previousElementSibling;
  var value = parseInt(input.value, 10);
  value = isNaN(value) ? 0 : value;
  value++;
  input.value = value;
  let price = document.getElementById("price-"+a);
  sum = price.getAttribute('data-price');
  sum = sum*value;
  price.innerHTML = sum+'đ';
}

function decreaseCount(a, b) {
  var input = b.nextElementSibling;
  var value = parseInt(input.value, 10);
  if (value > 1) {
    value = isNaN(value) ? 0 : value;
    value--;
    input.value = value;
    let price = document.getElementById("price-"+a);
  sum = price.getAttribute('data-price');
  sum = sum*value;
  price.innerHTML = sum+'đ';
  }
}
function Search(event){
  var keyWord = event.value;

  
      $.ajax({
        headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
          url: '/order/search/list/',
          method: 'POST',
          data:{keyWord:keyWord},
          success:function(data){
          
            var resultSearch = document.getElementById('resultSearch');
            var html = '';
            var modal = document.getElementById('myModal');
            if (data.result == null || data.result == undefined || data.result == '') {
                // Biến là rỗng
               html =  'Sản phẩm tìm kiếm không tồn tại'+'</p>';
               resultSearch.innerHTML = html;
               modal.style.display = 'block';
            } else {
              data.result.forEach(function(element) {
              html  +=  '<H2>' +'Kết quả tìm kiếm '+data.keyWord+'</H2>'+'<br>'+ `
              <li class="tf-box-row mb-12">
                  <a href="product-details-1.html" class="img-box">
                      <img src="/${element.thumb}" alt="img">
                  </a>
                  <div class="content-box">
                      <h5><a href="product-details-1.html">${element.name}</a></h5>
                      <ul class="review">
                          <li>
                              <i class="icon-star"></i>
                              <span>${element.content}</span>&nbsp;
                          </li>
                      </ul>
                      <div class="box-price">
                          <ul class="price">
                              <li class="accent">${element.price}đ</li>
                          </ul>
                          <button type="button" class="btn-add" data-name="p-${element.id}" onclick="openQuickView(this)">+</button>
                      </div>
                  </div>
              </li>
          `;
          });
            resultSearch.innerHTML = html;
               modal.style.display = 'block';
            }
        
          }
    
      });
}
function CusSearch(event){
  var keyWord = event.value;

  
      $.ajax({
        headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
          url: '/customer/search/list/',
          method: 'POST',
          data:{keyWord:keyWord},
          success:function(data){
           
            var resultSearch = document.getElementById('resultSearch');
            var html = '';
            var modal = document.getElementById('myModal');
            if (data.result == null || data.result == undefined || data.result == '') {
                // Biến là rỗng
          
                html =  '<p> Sản phẩm tìm kiếm không tồn tại </p>';
               resultSearch.innerHTML = html;
               modal.style.display = 'block';
            } else {
            
              data.result.forEach(function(element) {
              html  +=  `
              <li class="tf-box-row mb-12">
                  <a href="product-details-1.html" class="img-box">
                      <img src="/${element.thumb}" alt="img">
                  </a>
                  <div class="content-box">
                      <h5><a href="product-details-1.html">${element.name}</a></h5>
                      <ul class="review">
                          <li>
                              <i class="icon-star"></i>
                              <span>${element.content}</span>&nbsp;
                          </li>
                      </ul>
                      <div class="box-price">
                          <ul class="price">
                              <li class="accent">${element.price}đ</li>
                          </ul>
                          <button type="button" class="btn-add" data-name="p-${element.id}" onclick="openQuickView(this)">+</button>
                      </div>
                  </div>
              </li>
          `;
          });
            resultSearch.innerHTML = html;
               modal.style.display = 'block';
            }
        
          }
    
      });
}

function CusSearchMenu(event){
  var keyWord = event.getAttribute('data-key');

  
      $.ajax({
        headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
          url: '/customer/search/menu/',
          method: 'POST',
          data:{keyWord:keyWord},
          success:function(data){
          
            var resultSearch = document.getElementById('resultSearch');
            var html = '';
            var modal = document.getElementById('myModal');
            if (data.result == null || data.result == undefined || data.result == '') {
                // Biến là rỗng
              
              html = '<p>'+'Sản phẩm tìm kiếm không tồn tại'+'</p>';
               resultSearch.innerHTML = html;
               modal.style.display = 'block';
            } else {
              data.result.forEach(function(element) {
              html  +=`
              <li class="tf-box-row mb-12">
                  <a href="product-details-1.html" class="img-box">
                      <img src="/${element.thumb}" alt="img">
                  </a>
                  <div class="content-box">
                      <h5><a href="product-details-1.html">${element.name}</a></h5>
                      <ul class="review">
                          <li>
                              <i class="icon-star"></i>
                              <span>${element.content}</span>&nbsp;
                          </li>
                      </ul>
                      <div class="box-price">
                          <ul class="price">
                              <li class="accent">${element.price}đ</li>
                          </ul>
                          <button type="button" class="btn-add" data-name="p-${element.id}" onclick="openQuickView(this)">+</button>
                      </div>
                  </div>
              </li>
          `;
          });
            resultSearch.innerHTML = html;
               modal.style.display = 'block';
            }
        
          }
    
      });
}

