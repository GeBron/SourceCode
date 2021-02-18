function ImmediateAlerter() {
    this.valid = true;
    this.alert = function(element,text) {
        alert(text);
        this.valid = false;
    }

    this.showMessages = function() {}
}
