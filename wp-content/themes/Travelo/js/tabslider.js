jQuery(document).ready(function ($) {
    var jssor_2_options = {
        $AutoPlay: true,
        $DragOrientation: 2,
        $PlayOrientation: 2,
        $ThumbnailNavigatorOptions: {
            $Class: $JssorThumbnailNavigator$,
            $Cols: 9,
            $Orientation: 2,
            $Align: 0,
            $NoDrag: true
        }
    };

    var jssor_2_slider = new $JssorSlider$("jssor_2", jssor_2_options);

    //responsive code begin
    //you can remove responsive code if you don't want the slider scales while window resizing
    function ScaleSlider2() {
        var refSize = jssor_2_slider.$Elmt.parentNode.clientWidth;
        if (refSize) {
            refSize = Math.min(refSize, 700);
            jssor_2_slider.$ScaleWidth(refSize);
        }
        else {
            window.setTimeout(ScaleSlider2, 30);
        }
    }
    ScaleSlider2();
    $(window).bind("load", ScaleSlider2);
    $(window).bind("resize", ScaleSlider2);
    $(window).bind("orientationchange", ScaleSlider2);

    var jssor_1_options = {
        $AutoPlay: true,
        $ThumbnailNavigatorOptions: {
            $Class: $JssorThumbnailNavigator$,
            $Cols: 5,
            $Align: 200,
            $NoDrag: true
        }
    };

    var jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);

    //responsive code begin
    //you can remove responsive code if you don't want the slider scales while window resizing
    function ScaleSlider() {
        var refSize = jssor_1_slider.$Elmt.parentNode.clientWidth;
        if (refSize) {
            refSize = Math.min(refSize, 600);
            jssor_1_slider.$ScaleWidth(refSize);
        }
        else {
            window.setTimeout(ScaleSlider, 30);
        }
    }
    ScaleSlider();
    $(window).bind("load", ScaleSlider);
    $(window).bind("resize", ScaleSlider);
    $(window).bind("orientationchange", ScaleSlider);


});