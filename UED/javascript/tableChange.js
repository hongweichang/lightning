/**
 * Created with JetBrains WebStorm.
 * User: Soul
 * Date: 13-11-6
 * Time: 下午6:37
 * To change this template use File | Settings | File Templates.
 */

var viewTable = function (controlObject) {
        this.parentEle = controlObject.ele;
        this.childEle = controlObject.eleChild;
        this.length = this.childEle.length;
        this.controlEle = controlObject.eleControl;
        this.clickEle = controlObject.clickEle;
        this.buttonStyle = controlObject.buttonStyle;
        var i = 0,
            controlEle = this.controlEle,
            className = controlObject.classStr,
            _this = this;
        for (;i < this.length;i +=1 ) {
            this.childEle[i].index = i;
            controlEle[i].index = i;

        }

        //此处事件绑定直接改为jquery即可
        this.parentEle.click(function (e) {
            var clickEle = e.target;
            if (clickEle.tagName.toUpperCase() === _this.clickEle) {
                _this.display(clickEle.index,className);
            }
        });
    }

viewTable.prototype.display = function (index,className) {
    var i = 0;
    this.controlEle.removeClass(className);
    this.childEle.removeClass(this.buttonStyle);
    /*for (;i < this.length;i +=1) {
        classNameControl.removes(this.controlEle[i],className);
        classNameControl.removes(this.childEle[i],this.buttonStyle);
    }*/
    this.controlEle.eq(index).addClass(className);
    this.childEle.eq(index).addClass(this.buttonStyle);
};
/*new viewTable({
    ele : $("#find-table-button"),
    eleChild: $(".find-table-op"),
    eleControl : $(".find-table-box"),
    clickEle: "DIV",
    classStr : "find-table-box-show",
    buttonStyle: "find-table-op-hidden"
});*/
new viewTable({
    ele : $("#find-table-detail"),
    eleChild: $("#find-table-detail li"),
    eleControl : $(".find-table-content"),
    clickEle: "LI",
    classStr : "find-table-content-show",
    buttonStyle: "find-selected"
});

