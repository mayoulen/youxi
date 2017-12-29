var GameMain = /** @class */ (function () {
    function GameMain() {
        Laya.init(600, 300);
        // Laya.stage.bgColor = "#efefef";
        //文本
        // this.MyText();
        // 普通输入框
        this.MyTextInput();
    }
    GameMain.prototype.MyTextInput = function () {
        var textInput = new Laya.TextInput("Hello World");
        Laya.stage.addChild(textInput);
    };
    GameMain.prototype.MyText = function () {
        var txt = new Laya.Text();
        txt.text = "Hello World";
        txt.color = "#FFFFFF";
        txt.bold = true;
        txt.fontSize = 66;
        Laya.stage.addChild(txt);
    };
    return GameMain;
}());
new GameMain();
//# sourceMappingURL=HelloLayabox.js.map