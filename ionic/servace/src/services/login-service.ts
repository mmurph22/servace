import { Injectable } from '@angular/core';

@Injectable()
export class LoginService {

    constructor() { }


    /*  Login Universal Data
    ==============================*/
    getDataForLoginFlat = () => {
        let data = {
            "logo": "assets/imgs/ace_table_pan.png",
            "btnLogin": "Login",
            "txtUsername" : "Username",
            "txtPassword" : "Password",
            "txtForgotPassword" : "Forgot password?",
            "btnResetYourPassword": "Reset your password",
            "txtHaveAccount": "Already have an account?",
            "txtSignupnow" : "Don't have an account?",
            "btnSignupnow": "Signup now",
            "btnSignupVolnow": "Signup Volunteers",
            "btnSignupCoordnow": "Signup Coordinators",
            "title": "Welcome to ServACE,",
            "subtitle": "Hearts in Spades",
            "errorUser" : "Field can't be empty.",
            "errorPassword" : "Field can't be empty."
        };
        return data;
    };

    getPhpCommand = (phpCommandName: string) => {
        
    }
}
