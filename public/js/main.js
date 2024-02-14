var $ = jQuery.noConflict();

jQuery(document).ready(function () {
    
    $('#rent_start_date').daterangepicker({
      singleDatePicker: true,
      showDropdowns: true,
      // minDate:new Date(),
      minYear: 2020,
      maxYear: parseInt(moment().format('YYYY'),10),
      locale: {
        format: 'DD-MM-YYYY'
      }
    }, function(start, end, label) {});
    $('#inventory_purchase_date').daterangepicker({
      singleDatePicker: true,
      showDropdowns: true,
      // minDate:new Date(),
      minYear: 2020,
      maxYear: parseInt(moment().format('YYYY'),10),
      locale: {
        format: 'DD-MM-YYYY'
      }
    }, function(start, end, label) {});

    $('#datepicker01').daterangepicker({
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        "alwaysShowCalendars": true,
        locale: {
            cancelLabel: 'Clear'
        },
        // "startDate": "05/08/2020",
        // "endDate": "05/14/2020",
        "opens": "left"
    }, function(start, end, label) {
      console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
    });


    // $('input[type="file"].upload-profilepic').change(function(e){
    //     var fileName = e.target.files[0].name;
    //     alert( fileName );
    //     $('.selected-file').append(fileName);
    // });



    var $fileInput = $('.upload-profilepic');
    var $droparea = $('.img-dropbox');

    // highlight drag area
    $fileInput.on('dragenter focus click', function() {
      $droparea.addClass('is-active');
    });

    // back to normal state
    $fileInput.on('dragleave blur drop', function() {
      $droparea.removeClass('is-active');
    });

    // change inner text
    $fileInput.on('change', function() {
      var filesCount = $(this)[0].files.length;
      var $textContainer = $(this).prev();

      if (filesCount === 1) {
        // if single file is selected, show file name
        var fileName = $(this).val().split('\\').pop();
        $textContainer.empty();
        $textContainer.append("<img src='/backend/images/icons/tick.svg' width='50'> <strong>"+fileName+"</strong>");
      } else {
        // otherwise show number of files
        $textContainer.text(filesCount + ' files selected');
      }
    });

    $('.edit-btn').click(function(){
        $(this).parent('.defult-img').hide();
        $('.img-dropbox').show();
    });


    $('.hamburger').click(function(){
        $('.leftmenu').slideToggle();
    });
    $('.leftmenu .expand').click(function(){
        $(this).next('.subMenu').slideToggle();
    });


    $('.code-header .nav-item .nav-link').click(function(e){
        e.preventDefault();
        var getID = $(this).attr('data-id');
        $('.code-header .nav-link').removeClass('active');
        $(this).addClass('active');
        $('.code-main').removeClass('show');
        $('.code-main'+getID).addClass('show');
    });

$(window).resize(function () {

});
$(window).scroll(function () {
  var sticky = $('.scroll-to-top'),
  scroll = $(window).scrollTop();
  var winHeight = $(window).innerHeight();
  var winHalfHeight = winHeight / 2;

  if (scroll >= winHalfHeight) sticky.addClass('fixed');
  else sticky.removeClass('fixed');


  if ($(window).scrollTop() > 240) {
      $('.affilete-menu').addClass('fixed');
  } else {
      $('.affilete-menu').removeClass('fixed');
  }
});

});

