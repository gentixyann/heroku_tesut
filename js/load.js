alert('JavaScriptのアラート');

var removeAddressBar = function() {
     // 端末の向きを算出
     var isPortrait = window.innerHeight > window.innerWidth;
     // UserAgent から端末の種類を判別
     var ua = navigator.userAgent;
     var device;
     if (ua.search(/iPhone/) != -1 || ua.search(/iPod/) != -1) {
          device = "iPhone";
     } else if (ua.search(/Android/) != -1) {
          device = "Android";
     }
     // 端末の種類からページの高さを算出
     if (device == "Android") {
          h = Math.round(window.outerHeight / window.devicePixelRatio);
     } else if (device == "iPhone") {
          bar = (isPortrait ? 480 : screen.width) - window.innerHeight - (20 + (isPortrait ? 44 : 32));
          h = window.innerHeight + bar;
     } else {
          h = window.innerHeight;
     }
     // ページの高さをセット
     var body = $("body");
     if (body.height() < h) {
          body.height(h);
     }
     // ページをスクロール
     setTimeout(function() { scrollTo(0, 1); }, 100);
  };
  $("#remove-addressbar").click(function(e){
      e.preventDefault();
      removeAddressBar();
  });
  setInterval(function() {
   $("#height").html($(window).height());
  }, 1000);
