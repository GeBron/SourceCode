<?php
if (firstRequest()) {
    showLoginForm();
} elseif (loginSubmitted()) {
    tryAuthenticate();
} else {
    showPage();
}

function firstRequest() {
    return !loggedIn() && !loginSubmitted();
}

function tryAuthenticate() {
    authenticate();
    if (loggedIn()) {
        showPage();
    } else {
        showLoginForm();
    }
}
