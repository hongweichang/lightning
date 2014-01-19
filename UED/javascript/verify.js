/**
 * Created with JetBrains WebStorm.
 * User: Soul
 * Date: 13-11-10
 * Time: обнГ1:35
 * To change this template use File | Settings | File Templates.
 */

function Event(sender){
    this._sender = sender;
    this._listeners = [];
}
Event.prototype ={
    constructor: Event,

    attach: function(listener){
        this._listeners.push(listener)
    },

    notify: function(args) {
        var index,
            length =this._listeners.length;

        for(index = 0;index < length;i++){
            this._listeners[index](this._sender, args);
        }
    }
};

function ModelVerify () {

    this.rule = {};
        this.rule.email = /^([a-zA-Z0-9]+[_|-|.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|-|.]?)*[a-zA-Z0-9]+.[a-zA-Z]{2,3}$/;
        this.rule.mobileNumber = /1[3|5|8]\d{9}/;

    this.verify = new Event(this);

}

ModelVerify.prototype = {
    constructor: ModelVerify,

    sendVerifyData : function (verifyData) {
        this.verifyType = verifyData.type;
        this.verifyInformation = verifyData.data;
        this.verifyInf();
    },

    verifyInf : function() {
         var result =this.rule[this.verifyType].test(this.verifyInformation);
         this.verify.notify(result);
    }
};


function ViewVerify (model,pageElements){
    this._model = model;
    this._pageElements = pageElements;

    this.verify = new Event(this);

    var _this = this;

    this._model.verify.attach(function (sender,result) {
        _this.verifyNotify(result);
    });

    this._pageElements.addEventListener("blur",function(){
        _this.verify.notify();
    },false);
};

ViewVerify.prototype = {
    constructor: ModelVerify,

    verifyNotify: function (result) {
        alert(result)
    }
};

function ControlVerify (model,view) {
    this._model = model;
    this._view = view;

    var _this = this;

    this._view.verify.attach(function () {
        _this.sendToModel()
    });
}
ControlVerify.prototype = {
    constructor : ControlVerify,

    sendToModel : function () {
        var data = {
            type: "mobileNumber",
            data: "13008329397"
        }
        this._model.sendVerifyData(data);
    }
};

var model = new ModelVerify();
var view = new ViewVerify(model,document.getElementById("mobileNumber"));
var control = new ControlVerify(model,view);


