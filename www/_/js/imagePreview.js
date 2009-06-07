    function getFlashMovie (movieName) {
      var isIE = navigator.appName.indexOf("Microsoft") != -1;
      var m = (isIE) ? window["imgSwf"] : document["imgSwf"];
      return m;
    }

    function ready ()
    {
        alert ("ready to go");
        alert (getFlashMovie());
        getFlashMovie().getImages (clUrls);
    }