class GameMain {
    constructor(){
        Laya.init(600, 300);
        // Laya.stage.bgColor = "#efefef";
        //文本
        // this.MyText();

        // 普通输入框
        this.MyTextInput();

    }

    private MyTextInput() : void {
        var textInput : Laya.TextInput = new Laya.TextInput("Hello World");

        Laya.stage.addChild(textInput);
    }

    private MyText():void {
        var txt : Laya.Text = new Laya.Text();
        txt.text = "Hello World";
        txt.color = "#FFFFFF";
        txt.bold = true;
        txt.fontSize = 66;
        Laya.stage.addChild(txt);
    }

}

new GameMain();