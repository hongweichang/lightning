/**
 * Created with JetBrains WebStorm.
 * User: Soul
 * Date: 13-11-15
 * Time: обнГ10:43
 * To change this template use File | Settings | File Templates.
 */
var button_o = {};

button_o.ready = (function () {
    $(document).ready(function(){
        $(".open-fun-box").addClass("box-ani");
    });
})();

button_o.open = (function () {
    var classButton = $(".open-fun-box"),
        classDiv = $(".open-content"),
        length = classButton.length,
        i;

    for (i = 0;i < length;i++){
        classButton[i]["index"] = i;
    };

        classButton.click(function () {
            $(this).toggleClass("click");
            $(classDiv[this.index]).toggleClass("open-ani");
        });
})();