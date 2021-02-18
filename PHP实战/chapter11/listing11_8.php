<?php
if (loggedIn() or loginSubmitted()) {
    if (loginSubmitted()) {
        authenticate();
    }
    if (loggedIn()) {
        showPage();
    }
} else {
    showLoginForm();
}
