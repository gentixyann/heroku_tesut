//<!-- ポイント2つ -->
//  <!-- form、inputにidをつける -->
//  <!-- 関数でまとめる -->
//  <!-- Change Profile -->
    $(document).on('click', '#btn-submit', function(e) {
         e.preventDefault();
          popup();
    });

    // 関数で一つにまとめる
    function popup() {
      // optionsの中身を設定 = ボタンを押した時に出るダイアログ
      var options = {
        title: "プロフィール情報を変更しますか",
        icon: "info",
        buttons: {
          cancel: "Cancel", // キャンセルボタン
          ok: true
        }
      };

      // この関数がコールバック処理をしている
      swal(options)
        // then() メソッドを使えばクリックした時の値が取れます
        .then(function(val) {
          console.log(val)
          if (val) {
            // Okボタンが押された時の処理
            // この中でコールバック処理をしている
            swal({
              text: "プロフィール情報が変更されました",
              icon: "success",
            });
        // submitされた何秒後に自動的に閉じる
              setTimeout(
                function(){
                  // ()の中はformのidからきている #myform #はidを指定する時に使い、. はclassを指定する時に使う
               $('#update').submit();
              },2000);

          } else {
            // キャンセルボタンを押した時の処理
            // この中でコールバック処理をしている
            // valには 'null' が返ってきます
            swal({
              text: "キャンセルされました",
              icon: "warning",
              buttons: false,
              timer: 2500 // 2.5秒後に自動的に閉じる
            });
          }
      });
    }

        $(document).on('click', '.btn, .btn-default, .delete', function(d) {
         d.preventDefault();
         
         console.log(d);
         console.log(d.target.id);
         // console.log($('.btn, .btn-default, .delete').attr('data-add'));
         d_popup($('#'+d.target.id).data('add'));
    });

    //Post Delete
    // 関数で一つにまとめる
    function d_popup(titletext) {

      // optionsの中身を設定 = ボタンを押した時に出るダイアログ
      var d_options = {
        // title: "<?php //echo $one_movie["address"]; ?>[2018-01-25]を削除しますか?",
        title: titletext,
        icon: "info",
        buttons: {
          cancel: "Cancel", // キャンセルボタン
          ok: true
        }
      };

      // この関数がコールバック処理をしている
      swal(d_options)
        // then() メソッドを使えばクリックした時の値が取れます
        .then(function(del) {
          console.log(del)
          if (del) {
            // Okボタンが押された時の処理
            // この中でコールバック処理をしている
            swal({
              // text: "<?php //echo $one_movie  ["address"]; ?>[2018-01-25]を削除しました",
              text: titletext,
              icon: "success",
            });
        // submitされた何秒後に自動的に閉じる
              setTimeout(
                function(){
                  // ()の中はformのidからきている #myform #はidを指定する時に使い、. はclassを指定する時に使う
               $('#delete').submit();
              },2000);

          } else {
            // キャンセルボタンを押した時の処理
            // この中でコールバック処理をしている
            // valには 'null' が返ってきます
            swal({
              text: "キャンセルされました",
              icon: "warning",
              buttons: false,
              timer: 2500 // 2.5秒後に自動的に閉じる
            });
          }
      });
    }