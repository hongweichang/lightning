/**
 * Created with JetBrains WebStorm.
 * User: Soul
 * Date: 13-11-13
 * Time: ����8:21
 * To change this template use File | Settings | File Templates.
 */
function Event (sender) {
    this._sender = sender;
    this._listener = [];
}
Event.prototype = {
    constructor: Event,

    attach: function (fn) {
        this._listener.push(fn);
    },

    notify: function(arg) {
        var index,
            length = this._listener.length;

        for (index = 0;index < length;index +=1) {
            this._listener[index](this._sender,arg);
        }
    }
}
var ModelAjax = function (dataO) {
    this.getContent = new Event(this);
    this.alert = new Event(this);
};
ModelAjax.prototype.getAjax = function (e) {
    var _this = this;
    if(e.method === "check"){
        _this.alert.notify(e);
    }
    if(e.method === "list"){
        if(e.url){
            $.ajax({
                url: e.url,
                success:function(data){
                    e.data = data;
                    _this.getContent.notify(e);
                }
            });
        }else{
            _this.getContent.notify(e);
        }
    }
}
var ViewAjax = function (model,eleS) {
    this._model = model;
    this._li = eleS.eleLi;

    this.getIdAjax = new Event(this);
    this.alert = new Event(this);

    var _this = this;

    this._model.getContent.attach(function (sender,e) {
        _this.tableChange(e);
    });

    this._model.alert.attach(function(sender,e){
        _this.showAlert(e);
    })

    eleS.message.click(function(e){
        var ele = e.target;
        if(ele.tagName.toUpperCase() === "A"){
            _this.getIdAjax.notify({e:e,method:"check",id:$(ele).attr("data-method")});
        }
    });

    eleS.ele.click(function(e){
        _this.getIdAjax.notify({e:e.target,method:"list"});
    });
};
ViewAjax.prototype = {
    constructor: ViewAjax,

    tableChange: function (e) {
        $(".back-right").html(e.data);
        $(".back-right").attr("id", e.e.id);
        $(this._li).removeClass();


        if($(e.e).children("ul").length){
            $(e.e).addClass("back-nav-list-2");
        }else if(e.e.parentNode.className){
            e.e.parentNode.parentNode.className = "back-nav-list-2";
            $(e.e.parentNode).children("li").removeClass();
            $(e.e).addClass("nav-list-c");
        }
        else{
            $(e.e).addClass("back-nav-list-1");
        }
    },
    showAlert: function (e) {
        if(e === "check-credit"){
           alert(e);
        }
        if(e === "check-account"){
            alert(e);
        }
        if(e === "check-pass"){
            alert(e);
        }
        if(e === "delete"){
            alert(e);
        }
        if(e === "freeze"){
            alert(e);
        }
        if(e === "modify"){
            alert(e);
        }
        if(e === "smart-lists"){
            alert(e);
        }
        if(e === "operation-detail"){
            alert(e);
        }
        if(e === "check-tender"){

        }
        if(e === "check-money-where"){

        }
        if(e === "check-return"){

        }
        if(e === "modify-read"){

        }
        if(e === "modify-write"){

        }
        if(e === "modify-return"){

        }
        if(e === "allow-get") {

        }
        if(e === "reject-get") {

        }
        if(e === "check-user") {

        }
        if(e === "return-money"){

        }
        if(e === "check-inf-message"){

        }
        if(e === "add-return"){

        }
    }
}
function userUser () {
    var passOne = $("#pass-first");
        passOne.show();
}
function userAdminCHeck () {
    var passOne = $("#pass-first"),
        noPass = $("#nopass"),
        passTwo = $("#pass-second"),
        repeat = $("#repeat");
    passOne.show();
    noPass.click(function () {
        passOne.hide();
        passTwo.show();
        repeat.click(function () {
            passTwo.hide();
        })
    });
}
var ControlAjax = function (view,model) {
    this._view = view;
    this._model = model;

    var _this = this;

    this._view.getIdAjax.attach(function (sender,e){
        _this.getId(e);
    });
};
ControlAjax.prototype = {
    constructor: ControlAjax,

    getId: function (e) {
        if(e.e.id){
            e.url = e.e.id +".html";
        }
        this._model.getAjax(e);
    }
};
var mAjax = new ModelAjax();
var vAjax = new ViewAjax(mAjax,{
    ele : $("#left-back"),
    eleLi : $("#left-back>li"),
    message: $(".back-right")
});
var cAjax = new ControlAjax(vAjax,mAjax);
