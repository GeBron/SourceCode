function minLength(control,text,minlength) {
    if (control.value.length >= minlength) return true;
    alerter.alert(control,
       '\''+text+'\' must be at least '+minlength+' characters');
    return false;
}

function required(control,text) {
    if (control.value) return true;
    alerter.alert(control,'\''+text+'\' must be filled in');
    return false;
}

function equalInputs(control,text,othername) {
    var othercontrol = control.form.elements[othername]
    if (control.value == othercontrol.value) return true;
    alerter.alert(control,text+' don\'t match');
    return false;
}
