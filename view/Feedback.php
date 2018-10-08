<?php

namespace View;

class Feedback {

    public function missingUsername(): string {
        return 'Username is missing';
    }

    public function missingPassword(): string {
        return 'Password is missing';
    }

    public function incorrectCredentials(): string {
        return 'Wrong name or password';
    }

    public function loggedIn(): string {
        return 'Welcome';
    }

    public function loggedInSaveCookie(): string {
        return 'Welcome and you will be remembered';
    }

    public function logOut(): string {
        return 'Bye bye!';
    }

    public function usernameTooShort(): string {
        return 'Username has too few characters, at least 3 characters.';
    }

    public function passwordTooShort(): string {
        return 'Password has too few characters, at least 6 characters.';
    }

    public function passwordsNotMatching(): string {
        return 'Passwords do not match.';
    }

    public function invalidCharacters(): string {
        return 'Username contains invalid characters.';
    }

    public function userExists(): string {
        return 'User exists, pick another username.';
    }
}
