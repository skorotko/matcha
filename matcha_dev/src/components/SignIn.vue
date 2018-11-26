<template>
    <div>
        <div v-if="seen">
            <div class="form_wrapper">
                <div class="form_container">
                    <div class="title_container">
                        <h2>Please, sign in before continue</h2>
                    </div>
                    <div class="row clearfix">
                        <div class="">
                            <form id="sign-in-form">
                                <div class="input_field">
                                    <md-field md-clearable>
                                        <label style="font-size: 10px; margin-left: 2px">Email</label>
                                        <md-input style="font-size: 12px;" type="email" name="login-email"
                                                  v-model="signinEmail"
                                                  required></md-input>
                                    </md-field>
                                </div>
                                <div class="input_field">
                                    <md-field style="margin-top: -25px">
                                        <label style="font-size: 10px; margin-left: 2px">Password</label>
                                        <md-input style="font-size: 12px;" v-model="signinPassword"
                                                  name="login-password" type="password"
                                                  required></md-input>
                                    </md-field>
                                    <p id="check-signin">{{ signinAJAX }}</p>
                                </div>
                                <input id='login-data' class="button" type="submit" value="Sign in"
                                       v-on:click.prevent="checkSignInAJAX"/>
                                <span id="or">or</span>
                                <input v-on:click="changeSeen" id='register-data' class="button" type="button"
                                       value="Register">
                                <p v-on:click="recoveryAction" id='recovery' class="forgot-password">
                                    Forgot password?</p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div v-if="recovery">
            <div class="form_wrapper">
                <div class="form_container">
                    <div class="title_container">
                        <h2>Recovery</h2>
                    </div>
                    <div class="row clearfix">
                        <div class="">
                            <form id="recovery-form">
                                <div class="input_field">
                                    <md-field style="margin-top: -25px">
                                        <label style="font-size: 10px; margin-left: 2px">Your email</label>
                                        <md-input style="font-size: 12px"
                                                  v-model="recoveryMail" name="recovery" type="text"
                                                  required></md-input>
                                    </md-field>
                                    <p id="check-recovery">{{ recoveryText }}</p>
                                </div>
                                <input id='recovery-data' v-on:click.prevent="mailRegular(recoveryMail)" class="button" type="submit"
                                       value="Recovery"/>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div v-if="registration">
            <div class="form_wrapper">
                <div class="form_container">
                    <div class="title_container">
                        <h2>Registration</h2>
                    </div>
                    <div class="row clearfix">
                        <div class="">
                            <form id="register-form">
                                <div class="input_field">
                                    <md-field md-clearable>
                                        <label style="font-size: 10px; margin-left: 2px">Login</label>
                                        <md-input style="font-size: 12px" id="border-color" type="text"
                                                  name="register-login" v-model="login" v-on:blur="checkLoginAJAX"
                                                  required></md-input>
                                    </md-field>
                                    <p id="check-login">{{ loginAJAX }}</p>
                                </div>
                                <div class="input_field">
                                    <md-field md-clearable>
                                        <label style="font-size: 10px; margin-left: 2px">Email</label>
                                        <md-input style="font-size: 12px" id="border-color-too" type="email"
                                                  name="register-email" v-model="mail" v-on:blur="checkMailAJAX"
                                                  required></md-input>
                                    </md-field>
                                    <p id="check-mail">{{ mailAJAX }}</p>
                                </div>
                                <div class="input_field">
                                    <md-field>
                                        <label style="font-size: 10px; margin-left: 2px">Password</label>
                                        <md-input style="font-size: 12px" id="border-password" v-model="passwordCheck"
                                                  name="register-password" type="password" v-on:blur="checkPasswordAJAX"
                                                  required></md-input>
                                    </md-field>
                                </div>
                                <div class="input_field">
                                    <md-field style="margin-top: -25px">
                                        <label style="font-size: 10px; margin-left: 2px">Retype Password</label>
                                        <md-input style="font-size: 12px" id="border-password-too"
                                                  v-model="repasswordCheck" name="register-repassword" type="password"
                                                  v-on:blur="checkPasswordAJAX"
                                                  required></md-input>
                                    </md-field>
                                    <p id="check-password" v-html="passwordAJAX"></p>
                                </div>
                                <input id='submit-data' v-on:click.prevent="checkAllAJAX" class="button" type="submit"
                                       value="Register"/>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import {bus} from '../js/bus.js'
    import axios from 'axios'

    export default {
        name: 'SignInForm',
        data: function () {
            return {
                recoveryText: '',
                recoveryMail: '',
                recovery: false,
                disabledLogin: false,
                disabledEmail: false,
                disabledPasswords: false,
                disabled: true,
                seen: false,
                registration: false,
                loginAJAX: '',
                mailAJAX: '',
                passwordAJAX: '',
                signinAJAX: '',
                login: '',
                mail: '',
                passwordCheck: '',
                repasswordCheck: '',
                signinPassword: '',
                signinEmail: '',
                tmpLogin: ''
            }
        },
        methods: {
            recoveryAction() {
                this.seen = false
                this.registration = false
                this.recovery = true
            },
            changeSeen() {
                this.seen = !this.seen
                this.registration = !this.registration
                this.recovery = false
            },
            checkLoginAJAX() {
                axios.post('http://10.111.4.5:8080/registration/checkLoginAJAX', {
                    registerLogin: this.login
                }).then((response) => {
                    if (response.data === true) {
                        this.loginAJAX = "Ok, login is available"
                        $('#border-color').css('borderColor', 'green')
                        $('#check-login').css('color', 'green')
                        this.disabledLogin = true
                        if (this.disabledLogin === true && this.disabledEmail === true && this.disabledPasswords === true) {
                            this.disabled = false
                        }
                    }
                    else if (response.data === false) {
                        this.loginAJAX = "Such login already exists"
                        $('#border-color').css('borderColor', 'red')
                        $('#check-login').css('color', 'red');
                        this.disabledLogin = false
                    }
                    else if (response.data === "empty") {
                        this.loginAJAX = "Login can`t be empty!"
                        $('#border-color').css('borderColor', 'red')
                        $('#check-login').css('color', 'red');
                        this.disabledLogin = false
                    }
                    else if (response.data === 1) {
                        this.loginAJAX = "Must be between 4 and 20 characters!"
                        $('#border-color').css('borderColor', 'red')
                        $('#check-login').css('color', 'red');
                        this.disabledLogin = false
                    }
                    else if (response.data === 2) {
                        this.loginAJAX = "Should be only latin letters!"
                        $('#border-color').css('borderColor', 'red')
                        $('#check-login').css('color', 'red');
                        this.disabledLogin = false
                    }
                }).catch(function (error) {
                    console.log(error);
                });
            },
            mailRegular(email) {
                let re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                if (re.test(email)) {
                    this.seen = true;
                    this.registration = false;
                    this.recovery = false;
                    axios.post('http://10.111.4.5:8080/Recovery/recovery', {
                        recoveryEmail: this.recoveryMail
                    })
                }
                else {
                    this.recoveryText = "Wrong format!";
                    $('#check-recovery').css('borderColor', 'red');
                    $('#recovery-form').css('color', 'red');
                }
            },
            checkMailAJAX() {
                axios.post('http://10.111.4.5:8080/registration/checkMailAJAX', {
                    registerMail: this.mail
                }).then((response) => {
                    if (response.data === true) {
                        this.mailAJAX = "Ok, email is available!"
                        $('#border-color-too').css('borderColor', 'green')
                        $('#check-mail').css('color', 'green')
                        this.disabledEmail = true
                        if (this.disabledLogin === true && this.disabledEmail === true && this.disabledPasswords === true) {
                            this.disabled = false
                        }
                    }
                    else if (response.data === false) {
                        this.mailAJAX = "Such email already exists!"
                        $('#border-color-too').css('borderColor', 'red')
                        $('#check-mail').css('color', 'red')
                        this.disabledEmail = false
                    }
                    else if (response.data === "empty") {
                        this.mailAJAX = "Email can`t be empty!"
                        $('#border-color-too').css('borderColor', 'red')
                        $('#check-mail').css('color', 'red')
                        this.disabledEmail = false
                    }
                    else if (response.data === 1) {
                        this.mailAJAX = "Invalid email format!"
                        $('#border-color-too').css('borderColor', 'red')
                        $('#check-mail').css('color', 'red')
                        this.disabledEmail = false
                    }
                }).catch(function (error) {
                    console.log(error);
                });
            },
            checkPasswordAJAX() {
                axios.post('http://10.111.4.5:8080/registration/checkPasswordAJAX', {
                    registerPassword: this.passwordCheck,
                    registerRePassword: this.repasswordCheck
                }).then((response) => {
                    if (response.data === true) {
                        $('#border-password').css('borderColor', 'green')
                        $('#border-password-too').css('borderColor', 'green')
                        this.passwordAJAX = ""
                        this.disabledPasswords = true
                        if (this.disabledLogin === true && this.disabledEmail === true && this.disabledPasswords === true) {
                            this.disabled = false
                        }
                    }
                    else if (response.data === 2) {
                        this.passwordAJAX = "Min: 8 symbols, one lowercase, one uppercase!"
                        $('#border-password').css('borderColor', 'red')
                        $('#border-password-too').css('borderColor', 'red')
                        $('#check-password').css('color', 'red')
                        this.disabledPasswords = false
                    }
                    else if (response.data === "emptyP") {
                        this.passwordAJAX = "Don`t forget enter the password!"
                        $('#border-password').css('borderColor', 'red')
                        $('#border-password-too').css('borderColor', 'red')
                        $('#check-password').css('color', 'red')
                        this.disabledPasswords = false
                    }
                    else if (response.data === "emptyR") {
                        this.passwordAJAX = ""
                        $('#border-password').css('borderColor', 'red')
                        $('#border-password-too').css('borderColor', 'red')
                        $('#check-password').css('color', 'red')
                        this.disabledPasswords = false
                    }
                    else if (response.data === 1) {
                        this.passwordAJAX = "Passwords do not match!"
                        $('#border-password').css('borderColor', 'red')
                        $('#border-password-too').css('borderColor', 'red')
                        $('#check-password').css('color', 'red')
                        this.disabledPasswords = false
                    }
                }).catch(function (error) {
                    console.log(error);
                });
            },
            checkAllAJAX() {
                this.checkLoginAJAX();
                this.checkMailAJAX();
                this.checkPasswordAJAX();
                if (this.passwordCheck === this.repasswordCheck && this.passwordCheck && this.repasswordCheck && this.disabledEmail !== false && this.disabledLogin !== false && this.disabledPasswords !== false) {
                    bus.$emit("showMessageEmailConfirmNeed", true)
                    axios.post('http://10.111.4.5:8080/registration/registration', {
                        registerLogin: $('#border-color').val(),
                        registerEmail: $('#border-color-too').val(),
                        registerRepassword: $('#border-password').val(),
                        registerPassword: $('#border-password-too').val()
                    })
                }
            },
            checkSignInAJAX() {
                axios.post('http://10.111.4.5:8080/login/signInAJAX', {
                    signInEmail: this.signinEmail,
                    signInPassword: this.signinPassword
                }).then((response) => {
                    if (response.data.name === undefined) {
                        localStorage.setItem("rating", false);
                        this.signinAJAX = response.data;
                        $('#check-signin').css('color', 'red');
                    }
                    else {
                        this.signinAJAX = '';
                        this.tmpLogin = response.data.name;
                        axios.post('http://10.111.4.5:8080/token/getToken', {
                            userLogin: response.data.name
                        }).then((response) => {
                            localStorage.setItem("userName", response.data)
                        }).catch(function (error) {
                            console.log(error);
                        });
                        axios.post('http://10.111.4.5:8080/CheckRating/returnRating', {
                            userLogin: this.tmpLogin
                        }).then((response) => {
                            localStorage.setItem("rating", response.data);
                        });
                        setTimeout(function () {
                            bus.$emit('stopRenderApp', false);
                            bus.$emit('showMessageEmailConfirmNeed', false)
                            $('html').removeClass('active shadowed');
                            bus.$emit("fillProfile", true)
                        }, 500);
                    }
                }).catch(function (error) {
                    console.log(error);
                });
            }
        }
        ,
        created() {
            bus.$on("changeSeen", (data) => {
                this.seen = data;
                this.recovery = false;
                this.registration = false;
                if (this.registration === false) {
                    this.signinEmail = '',
                        this.signinPassword = '',
                        this.signinAJAX = '',
                        this.loginAJAX = '',
                        this.mailAJAX = '',
                        this.login = '',
                        this.mail = '',
                        this.passwordCheck = '',
                        this.repasswordCheck = ''
                }
            })
        }
        ,
        mounted() {
            $(function () {
                axios.post('http://10.111.4.5:8080/CheckOnlineStatus/checkOnlineStatus', {
                    token: localStorage.getItem("userName")
                }).then((response) => {
                    if (response.data === "online") {
                        bus.$emit('stopRenderApp', false);
                        bus.$emit('showMessageEmailConfirmNeed', false);
                        $('html').removeClass('active shadowed');
                        bus.$emit("fillProfile", true);
                    }
                }).catch(function (error) {
                    console.log(error);
                });
            })
        }
    }
</script>

<style scoped>
    .forgot-password {
        font-size: 12px;
        font-style: italic;
        color: blue;
        cursor: pointer;
        display: flex;
        justify-content: center;
    }

    .clearfix:after {
        content: "";
        display: block;
        clear: both;
        visibility: hidden;
        height: 0;
    }

    .form_wrapper {
        z-index: 999;
        background-color: white;
        width: 320px;
        max-width: 100%;
        box-sizing: border-box;
        padding: 25px;
        top: 50%;
        left: 50%;
        margin-top: -180px;
        margin-left: -160px;
        position: fixed;
        border-top: 5px solid #f5ba1a;
        -webkit-box-shadow: 0 0 3px rgba(0, 0, 0, 0.1);
        -moz-box-shadow: 0 0 3px rgba(0, 0, 0, 0.1);
        box-shadow: 0 0 3px rgba(0, 0, 0, 0.1);
        -webkit-transform-origin: 50% 0;
        transform-origin: 50% 0;
        -webkit-transform: scale3d(1, 1, 1);
        transform: scale3d(1, 1, 1);
        -webkit-transition: none;
        transition: none;
        -webkit-animation: expand 0.8s 0.6s ease-out forwards;
        animation: expand 0.8s 0.6s ease-out forwards;
        opacity: 0;
    }

    .form_wrapper h2 {
        font-size: 1em;
        line-height: 1.5em;
        margin: 0;
    }

    .form_wrapper .title_container {
        text-align: center;
        padding-bottom: 15px;
    }

    .form_wrapper h3 {
        font-size: 1.1em;
        font-weight: normal;
        line-height: 1.5em;
        margin: 0;
    }

    .form_wrapper label {
        font-size: 12px;
    }

    .form_wrapper .row {
        margin: 10px -15px;
    }

    .form_wrapper .row > div {
        padding: 0 15px;
        box-sizing: border-box;
    }

    .form_wrapper .col_half {
        width: 50%;
        float: left;
    }

    .form_wrapper .col_quarter {
        width: 25%;
        float: left;
    }

    .form_wrapper .input_field {
        position: relative;
        margin-bottom: 20px;
        -webkit-animation: bounce 0.6s ease-out;
        animation: bounce 0.6s ease-out;
    }

    .form_wrapper .input_field > p {
        line-height: 0
    }

    .form_wrapper .input_field > span > i {
        padding-top: 10px;
    }

    .form_wrapper .textarea_field > span > i {
        padding-top: 10px;
    }

    .form_container .row .col_half.last {
        border-left: 1px solid #cccccc;
    }

    .checkbox_option label {
        margin-right: 1em;
        position: relative;
    }

    .checkbox_option label:before {
        content: "";
        display: inline-block;
        width: 0.5em;
        height: 0.5em;
        margin-right: 0.5em;
        vertical-align: -2px;
        border: 2px solid #cccccc;
        padding: 0.12em;
        background-color: transparent;
        background-clip: content-box;
        transition: all 0.2s ease;
    }

    .checkbox_option label:after {
        border-right: 2px solid #000000;
        border-top: 2px solid #000000;
        content: "";
        height: 20px;
        left: 2px;
        position: absolute;
        top: 7px;
        transform: scaleX(-1) rotate(135deg);
        transform-origin: left top;
        width: 7px;
        display: none;
    }

    .checkbox_option input:hover + label:before {
        border-color: #000000;
    }

    .checkbox_option input:checked + label:before {
        border-color: #000000;
    }

    .checkbox_option input:checked + label:after {
        -moz-animation: check 0.8s ease 0s running;
        -webkit-animation: check 0.8s ease 0s running;
        animation: check 0.8s ease 0s running;
        display: block;
        width: 7px;
        height: 20px;
        border-color: #000000;
    }

    .select_arrow {
        position: absolute;
        top: calc(50% - 4px);
        right: 15px;
        width: 0;
        height: 0;
        pointer-events: none;
        border-width: 8px 5px 0 5px;
        border-style: solid;
        border-color: #7b7b7b transparent transparent transparent;
    }

    .button {
        background: #f5ba1a;
        height: 35px;
        line-height: 35px;
        width: 100%;
        border: none;
        outline: none;
        cursor: pointer;
        color: #fff;
        font-size: 1.1em;
        -webkit-transition: all 0.3s ease-in-out;
        -moz-transition: all 0.3s ease-in-out;
        -ms-transition: all 0.3s ease-in-out;
        transition: all 0.3s ease-in-out;
    }

    .button:hover {
        background: #e1a70a;
    }

    .button:focus {
        background: #e1a70a;
    }

    /*.select_option select:hover + .select_arrow, .select_option select:focus + .select_arrow {*/
    /*border-top-color: #000000;*/
    /*}*/

    .credit {
        display: none;
        position: relative;
        z-index: 1;
        text-align: center;
        padding: 15px;
        color: #f5ba1a;
    }

    .credit a {
        color: #e1a70a;
    }

    @-webkit-keyframes check {
        0% {
            height: 0;
            width: 0;
        }
        25% {
            height: 0;
            width: 7px;
        }
        50% {
            height: 20px;
            width: 7px;
        }
    }

    @keyframes check {
        0% {
            height: 0;
            width: 0;
        }
        25% {
            height: 0;
            width: 7px;
        }
        50% {
            height: 20px;
            width: 7px;
        }
    }

    @-webkit-keyframes expand {
        0% {
            -webkit-transform: scale3d(1, 0, 1);
            opacity: 0;
        }
        25% {
            -webkit-transform: scale3d(1, 1.2, 1);
        }
        50% {
            -webkit-transform: scale3d(1, 0.85, 1);
        }
        75% {
            -webkit-transform: scale3d(1, 1.05, 1);
        }
        100% {
            -webkit-transform: scale3d(1, 1, 1);
            opacity: 1;
        }
    }

    @keyframes expand {
        0% {
            -webkit-transform: scale3d(1, 0, 1);
            transform: scale3d(1, 0, 1);
            opacity: 0;
        }
        25% {
            -webkit-transform: scale3d(1, 1.2, 1);
            transform: scale3d(1, 1.2, 1);
        }
        50% {
            -webkit-transform: scale3d(1, 0.85, 1);
            transform: scale3d(1, 0.85, 1);
        }
        75% {
            -webkit-transform: scale3d(1, 1.05, 1);
            transform: scale3d(1, 1.05, 1);
        }
        100% {
            -webkit-transform: scale3d(1, 1, 1);
            transform: scale3d(1, 1, 1);
            opacity: 1;
        }
    }

    @-webkit-keyframes bounce {
        0% {
            -webkit-transform: translate3d(0, -25px, 0);
            opacity: 0;
        }
        25% {
            -webkit-transform: translate3d(0, 10px, 0);
        }
        50% {
            -webkit-transform: translate3d(0, -6px, 0);
        }
        75% {
            -webkit-transform: translate3d(0, 2px, 0);
        }
        100% {
            -webkit-transform: translate3d(0, 0, 0);
            opacity: 1;
        }
    }

    @keyframes bounce {
        0% {
            -webkit-transform: translate3d(0, -25px, 0);
            transform: translate3d(0, -25px, 0);
            opacity: 0;
        }
        25% {
            -webkit-transform: translate3d(0, 10px, 0);
            transform: translate3d(0, 10px, 0);
        }
        50% {
            -webkit-transform: translate3d(0, -6px, 0);
            transform: translate3d(0, -6px, 0);
        }
        75% {
            -webkit-transform: translate3d(0, 2px, 0);
            transform: translate3d(0, 2px, 0);
        }
        100% {
            -webkit-transform: translate3d(0, 0, 0);
            transform: translate3d(0, 0, 0);
            opacity: 1;
        }
    }

    @media (max-width: 600px) {
        .form_wrapper .col_half {
            width: 100%;
            float: none;
        }

        .bottom_row .col_half {
            width: 50%;
            float: left;
        }

        .form_container .row .col_half.last {
            border-left: none;
        }

        .remember_me {
            padding-bottom: 20px;
        }
    }

    .for-register-link {
        cursor: pointer;
        color: blue;
        font-weight: bold;
        font-family: 'Lato', sans-serif;
    }

    #or {
        position: relative;
        left: 50%;
        margin-left: -5px;
        padding-top: -5px;
    }

    #check-login, #check-mail {
        margin-top: -10px;
        margin-bottom: -25px;
        text-align: center;
        font-size: 12px;
    }

    #check-password {
        margin-top: -10px;
        margin-bottom: -12px;
        text-align: center;
        font-size: 10px;
    }

    #check-signin {
        text-align: center;
        font-size: 12px;
    }
    #check-recovery {
        margin-top: -10px;
        text-align: center;
        font-size: 12px;
    }
</style>
