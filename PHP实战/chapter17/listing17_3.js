function DelayedAlerter() {
    this.messages = new Array();
    this.valid = true;
    this.alert = function(element,text) {
        this.messages[element.name] = text;
        this.valid = false;
    }

    this.showMessages = function() {
        for (var name in this.messages) {
            alert(this.messages[name]);
        }
    }
}
