/**
 * Created by Soul on 13-11-24.
 */
(function () {
    //上传触发
    $(".up_banner_start").click(function () {
        var _this = this,
            next = $(_this).next();
            next.click().change(function () {
                next.prev().prev().prev().attr("src",this.value);
            })
    })
})();
