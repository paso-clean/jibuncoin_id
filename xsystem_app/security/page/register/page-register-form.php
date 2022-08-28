<html>

<head>
  <title>XSYSTEM app</title>
  <meta name=”description“ content=“ジブンコイン・アプリケーション“>
  <link rel="apple-touch-icon" sizes="76x76" href="<?php echo XSYSTEM_ASSET_URL; ?>img/apple-icon.png">
  <link rel="icon" type="image/png" href="<?php echo XSYSTEM_ASSET_URL; ?>img/favicon.png">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.css">
  <link rel="stylesheet" href="<?php echo XSYSTEM_COMMON_ASSET_URL; ?>fontawesome/css/all.min.css">
  <link href="<?php echo XSYSTEM_COMMON_ASSET_URL; ?>cropper/css/cropper.css" rel="stylesheet" />
  <link rel="stylesheet" href="<?php echo XSYSTEM_ASSET_URL; ?>css/content.css">

  <style>
    <?php //require_once XSYSTEM_APP_DIR  . '/include/include-css-login.php'; 
    ?>
  </style>

</head>

<body>
  <div class="wrapper">



    <div id="main-content">
      <div class="swiper-container">
        <div class="swiper-wrapper">

          <div id="target-content" class="btn-ajax" data-fixed=1 data-url="<?php echo XSYSTEM_APP_URL; ?>ajax/register/form/"></div>


        </div><!-- /swiper-wrapper -->
      </div><!-- /swiper-container -->
    </div><!-- /main-content -->


  </div><!-- /wrapper -->


  <?php require_once XSYSTEM_APP_DIR  . 'include/include-modal.php'; ?>

  <div id="loader-bg">
    <div id="loader">
      <img src="<?php echo XSYSTEM_ASSET_URL; ?>img/loading_img.png" class="loading-img" width="80" height="80" alt="Now Loading..." />
      <p id="loading-msg"></p>
    </div>
  </div>

  <script src="<?php echo XSYSTEM_COMMON_ASSET_URL; ?>js/jquery.min.js"></script>
  <script src="<?php echo XSYSTEM_COMMON_ASSET_URL; ?>js/jquery-ui.min.js"></script>
  <script src="<?php echo XSYSTEM_COMMON_ASSET_URL; ?>js/jquery.ui.touch-punch.min.js"></script>
  <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
  <script src="<?php echo XSYSTEM_COMMON_ASSET_URL; ?>cropper/js/cropper.js"></script>
  <script src="<?php echo XSYSTEM_COMMON_ASSET_URL; ?>js/common.js"></script>

  <script>
    $(function() {

      $(document).ready(function() {
        start_loading();
        $.when(
          $('#target-content').click(),
        ).done(function() {
          setTimeout(function() {
            end_loading();
          }, 1000);
        });
      });

      $(document).on('blur', '#zipcode', function() {
      	if($('#address').val() == '' && $('#zipcode').val() !== ''){
            zipcode($('#zipcode').val());
      	}else{
            alert($('#zipcode').val());
      	}
      });

      $(document).on('click', '.btn-back-form', function() {
        location.href = '';
      });

    });

    ajaxAction.post = function(formData) {
      let target;

      $.ajax({
          url: formData.get('url'),
          type: 'POST',
          data: formData,
          contentType: false,
          processData: false,
        })
        .done((data) => {
          if (formData.has('target')) {
            target = formData.get('target');
            $(target).html(data);
          } else {
            appModal.set_modal(data, false);
          }
        })
        .fail((data) => {
          alert($(obj).data('url') + ' error.');
        });
    }

    ajaxAction.register_confirm = function(obj) {
      if (check_form()) {
        let formData = new FormData();
        formData.append('url', $(obj).data('url'));
        formData.append('target', '#fixedModal .panelContent');
        formData.append('name1', $('#name1').val());
        formData.append('name2', $('#name2').val());
        formData.append('name1_kana', $('#name1-kana').val());
        formData.append('name2_kana', $('#name2-kana').val());
        formData.append('zipcode', $('#zipcode').val());
        formData.append('address', $('#address').val());
        formData.append('address1', $('#address1').val());
        formData.append('address2', $('#address2').val());
        formData.append('address3', $('#address3').val());
        formData.append('tel', $('#tel').val());
        formData.append('birth_year', $('#birth_year').val());
        formData.append('birth_month', $('#birth_month').val());
        formData.append('birth_day', $('#birth_day').val());
        formData.append('sex', $('input[name="sex"]').val());
        formData.append('email', $('#email').val());
        formData.append('email2', $('#email2').val());
        ajaxAction['post'](formData);
      } else {
        alert('入力情報に誤りがあります。');
      }

    }

    apiAction.register_sendmail = function(obj) {
      const btn_data = $(obj).data();
      const modal_num = appModal.get_panel();
      const target = '#fixedModal .panelContent';

      let formData = new FormData();
      formData.append('url', $(obj).data('url'));
      //formData.append('done', $(obj).data('done'));
      formData.append('target', target);

      apiAction['api'](formData);
    }

    apiAction.register_complete = function(obj) {
      const file_name = $('#uploader').val();
      if (file_name !== '') {
        const btn_data = $(obj).data();
        const modal_num = appModal.get_panel();
        const target = '#panelModal' + modal_num + ' .panelContent';

        canvas = $('#croppedCanvas')[0].toDataURL();
        let base64Data = canvas.split(',')[1];
        let data = window.atob(base64Data);
        let buff = new ArrayBuffer(data.length);
        let arr = new Uint8Array(buff);
        let blob;
        let i;
        let dataLen;
        let formData;

        for (i = 0, dataLen = data.length; i < dataLen; i++) {
          arr[i] = data.charCodeAt(i);
        }
        blob = new Blob([arr], {
          type: 'image/png'
        });

        formData = new FormData();
        formData.append('api', $(obj).data('api'));
        formData.append('target', target);
        formData.append('upfile', blob);

        apiAction['api'](formData);
      } else {
        alert('プロフィール画像がありません。');
      }
    }


    function check_form() {
      let is_check = true;
      let form_comment = '';

      check_email($('#email').val());


      if ($('#name1').val() == '') {
        $('#label-name1').css('color', '#ff0000');
        is_check = false;
      } else {
        $('#label-name1').css('color', '#463c3b');
      }


      if ($('#name2').val() == '') {
        $('#label-name2').css('color', '#ff0000');
        is_check = false;
      } else {
        $('#label-name2').css('color', '#463c3b');
      }

      if ($('#name1-kana').val() == '') {
        $('#label-name1-kana').css('color', '#ff0000');
        is_check = false;
      } else {
        $('#label-name1-kana').css('color', '#463c3b');
      }


      if ($('#name2-kana').val() == '') {
        $('#label-name2-kana').css('color', '#ff0000');
        is_check = false;
      } else {
        let str = $('#name2-kana').val();
        if (kana(str)) {
          $('#label-name2-kana').css('color', '#463c3b');
        } else {
          alert("カタカナで記入されていません。");
          $('#label-name2-kana').css('color', '#ff0000');
          is_check = false;
        }
      }

      if ($('#zipcode').val() == '') {
        $('#label-zipcode').css('color', '#ff0000');
        is_check = false;
      } else {
        zipcode($('#zipcode').val());
        $('#label-zipcode').css('color', '#463c3b');
      }



      if ($('#address').val() == '') {
        $('#label-address').css('color', '#ff0000');
        is_check = false;
      } else {
        $('#label-address').css('color', '#463c3b');
      }



      if ($('#tel').val() == '') {
        $('#label-tel').css('color', '#ff0000');
        is_check = false;
      } else {
        $('#label-tel').css('color', '#463c3b');
      }



      if ($('#email').val() === '') {
        $('#label-email').css('color', '#ff0000');
        is_check = false;
      } else {
        $('#label-email').css('color', '#463c3b');
      }


      if ($('#email2').val() !== $('#email').val()) {
        $('#label-email2').css('color', '#ff0000');
        is_check = false;
      } else {
        $('#label-email2').css('color', '#463c3b');
      }


      if (is_check) {
        return true;
      } else {
        $('#form-comment').text('入力に誤りがあります。');
        $('#form-comment').css('color', '#ff0000');
        return false;
      }
    }


    function zipcode(zipcode) {
      let api = $('#zipcode').data('api');
      zipcode = zipcode.replace('-', '');
      api = api + zipcode + '/';
      let data;
      let text;
      let address1;
      let address2;
      let address3;

      $.ajax({
          url: api,
          type: 'GET',
          dataType: "json",
        })
        .done((data) => {
          text = data.text;
          address1 = data.address1;
          address2 = data.address2;
          address3 = data.address3;
          $('#address').val(text);
          $('#address1').val(address1);
          $('#address2').val(address2);
          $('#address3').val(address3);
        })
        .fail((data) => {
          alert('.zipcode error.');
        });

    }

    function check_email(email) {
      let api = $('#email').data('api');
      let content = '';

      $.ajax({
          url: api,
          type: 'POST',
          data: {
            email: email
          },
          dataType: "json",
        })
        .done((data) => {
          if (data.error === 0) {
            $('#label-email').css('color', '#463c3b');
          } else {
            content = data.content;
            $('#label-email').css('color', '#ff00000');
            alert(content);
          }
        })
        .fail((data) => {
          alert(api + ' error.');
        });
    }

    function kana(s) {
      return !!s.match(/^[ァ-ヶー　]*$/);
    }

    function password_check() {
      let is_check = true;
      let form_comment = '';

      if ($('#password').val() === '') {
        $('#label-password').css('color', '#ff0000');
        is_check = false;
      } else {
        $('#label-password').css('color', '#463c3b');
      }

      if ($('#password2').val() !== $('#password').val()) {
        $('#label-password2').css('color', '#ff0000');
        is_check = false;
      } else {
        $('#label-password2').css('color', '#463c3b');
      }


      if (is_check) {
        return true;
      } else {
        $('#form-comment').text('入力に誤りがあります。');
        $('#form-comment').css('color', '#ff0000');
      }
    }
  </script>

</body>

</html>