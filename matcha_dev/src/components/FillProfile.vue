<template>
    <div v-if="seen">
        <slot></slot>
        <div class="for-mobile">
            <div class="form_wrapper">
                <div class="form_container">
                    <div class="title_container">
                        <h2>User Profile</h2>
                    </div>
                    <div class="row clearfix">
                        <div class="">
                            <form id='register-form' autocomplete="off">
                                <div class="row clearfix">
                                    <div class="foto">
                                        <label v-if="show" for="file">
                                            <input type="file" v-on:change="handleFileSelect" style="display: none"
                                                   id="file" accept="image/png,image/jpg,,image/jpeg">
                                            <img class="icon_foto_big" id="big" src="../images/icon_foto.png">
                                        </label>
                                        <canvas v-show="!show" id="canvas"></canvas>
                                        <input type="hidden" name="photo" id="photo" value="">
                                    </div>
                                    <div class="input_field">
                                        <div class="input_field">
                                            <md-field style="margin-top: -25px; margin-bottom: 0px" md-clearable>
                                                <label style="font-size: 10px; margin-left: 2px">First Name</label>
                                                <md-input style="font-size: 12px;" v-model="first_name"
                                                          v-on:blur="postFirstName" type="text"
                                                          name="first_name" required></md-input>
                                            </md-field>
                                            <span id="firstname" style="color: red; font-size: 12px"
                                                  v-html="answer"></span>
                                        </div>
                                    </div>
                                    <div class="input_field">
                                        <div class="input_field">
                                            <md-field style="margin-top: -20px;margin-bottom: 0px" md-clearable>
                                                <label style="font-size: 10px; margin-left: 2px">Second Name</label>
                                                <md-input style="font-size: 12px;" v-model="second_name"
                                                          v-on:blur="postSecondName" type="text"
                                                          name="last_name" required></md-input>
                                            </md-field>
                                            <span id="secondname" style="color: red; font-size: 12px"
                                                  v-html="answer_2"></span>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <md-radio v-model="radio" :value="false" id="male" type="radio" name="gender">Male
                                    </md-radio>
                                    <md-radio v-model="radio" id="female" type="radio" name="gender">Female</md-radio>
                                    <input type="hidden" name="gender" :value="radio">
                                </div>
                                <div class="md-layout md-gutter">
                                    <div class="md-layout-item">
                                        <md-field>
                                            <label for="preferences">Preferences</label>
                                            <md-select v-model="preferences" name="movie" id="preferences">
                                                <md-option value="Bisexual">Bisexual</md-option>
                                                <md-option value="Heterosexual">Heterosexual</md-option>
                                                <md-option value="Homosexual">Homosexual</md-option>
                                            </md-select>
                                            <input type="hidden" name="sexual_pref" :value="preferences">
                                        </md-field>
                                    </div>
                                    <div style="margin-left: 20px">
                                        <md-datepicker v-model="selectedDate" md-immediately required>
                                            <label>Your birthday</label>
                                        </md-datepicker>
                                        <input type="hidden" id="birthday" :value="selectedDate">
                                    </div>
                                </div>
                                <md-checkbox v-model="education">Higher education</md-checkbox>
                                <md-checkbox v-model="children">Children</md-checkbox>
                                <div class="sliderDiv">
                                    <p class="sliderDivP">Height</p>
                                    <p class="sliderDivValue">{{ height.value }}</p>
                                    <vue-slider v-model="height.value" class="mobile-range"
                                                v-bind="height"></vue-slider>
                                </div>
                                <div class="attitudes">
                                    <p>Religion attitude</p>
                                    <md-radio v-model="attitudes" v-bind:value="false">Atheist</md-radio>
                                    <md-radio v-model="attitudes" value="follow">Follow the tradition</md-radio>
                                    <md-radio v-model="attitudes" value="religious">Religious</md-radio>
                                </div>

                                <md-field>
                                    <label>About me</label>
                                    <md-textarea name="biography" v-model="textarea" maxlength="500"></md-textarea>
                                </md-field>
                                <md-field>
                                    <label>I`m interesting in</label>
                                    <md-textarea name="hobby" v-model="textareaCopy" maxlength="500"></md-textarea>
                                </md-field>
                                <md-snackbar :md-position="position" :md-duration="4000" :md-active.sync="showSnackbar"
                                             md-persistent>
                                    <span>{{ finalMessage }}</span>
                                    <md-button class="md-primary" v-on:click="showSnackbar = false">Close</md-button>
                                </md-snackbar>
                                <input id='submit-data' v-on:click.prevent="checkRequiredFields" class="button"
                                       type="submit"
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
    import axios from 'axios'
    import moment from 'moment'
    import VueSlider from 'vue-slider-component'
    import {bus} from '../js/bus.js'

    export default {
        name: 'nfr',
        data: function () {
            return {
                city: '',
                children: false,
                attitudes: false,
                education: false,
                seen: false,
                lat: '',
                lon: '',
                blockedLat: '',
                blockedLon: '',
                showSnackbar: false,
                position: 'center',
                duration: 3000,
                finalMessage: '',
                selectedDate: new Date(),
                textarea: null,
                textareaCopy: null,
                tmpHobby: '',
                preferences: 'Bisexual',
                radio: false,
                show: true,
                array: [],
                answer: '',
                answer_2: '',
                first_name: '',
                second_name: '',
                height: {
                    width: "100%",
                    show: true,
                    value: 150,
                    min: 150,
                    max: 220,
                    piecewiseLabel: false,
                    tooltip: false
                },
            }

        },
        components: {
            VueSlider,
        },
        methods: {
            showPosition: function (position) {
                this.lat = position.coords.latitude;
                this.lon = position.coords.longitude;
            },
            handleFileSelect: function (evt) {
                if (this.show) {
                    this.show = !this.show
                }
                const can = document.getElementById('canvas')
                const ctx = can.getContext('2d')
                const file = evt.target.files
                const f = file[0]
                const reader = new FileReader()
                reader.onload = (function (theFile) {
                    return function (e) {
                        const span = document.createElement('div')
                        span.id = 'del'
                        span.innerHTML = ['<img class="thumb" title="', decodeURI(theFile.name), '" src="', e.target.result, '" />'].join('')
                        const img = new Image()
                        img.src = e.target.result
                        img.onload = function () {
                            can.setAttribute('height', '130')
                            can.setAttribute('width', '130')
                            ctx.drawImage(img, 0, 0, 130, 130)
                        }
                        const photosrc = document.getElementById('photo')
                        photosrc.value = e.target.result
                    }
                })(f)
                if (f && f.type.match('image.*')) {
                    reader.readAsDataURL(f)
                }
            },
            hash (hobbies) {
                if (hobbies !== '') {
                    this.tmpHobby = hobbies;
                    const parseHashtags = require('parse-hashtags');
                    this.textareaCopy = parseHashtags(hobbies);
                }
            },
            checkRequiredFields() {
                if ($('#photo').val() === "") {
                    this.finalMessage = ''
                    this.showSnackbar = true
                    this.finalMessage = "Choose profile photo";
                    return;
                }
                if (this.first_name === "") {
                    this.finalMessage = ''
                    this.showSnackbar = true
                    this.finalMessage = "Fill your first name, please";
                    return;
                }
                if (this.second_name === "") {
                    this.finalMessage = ''
                    this.showSnackbar = true
                    this.finalMessage = "Fill your second name, please";
                    return;
                }
                if (this.selectedDate === null) {
                    this.finalMessage = ''
                    this.showSnackbar = true
                    this.finalMessage = "Select your birthday before continue";
                    return;
                }
                if (this.answer !== "" || this.answer_2 !== "") {
                    return; 
                }
                this.selectedDate = moment(this.selectedDate).format('YYYY-MM-DD HH:mm');
                this.hash(this.textareaCopy);
                axios.post('http://10.111.4.5:8080/UserProfile/fillingInUserProfile', {
                    children: this.children,
                    height: this.height.value,
                    education: this.education,
                    attitude: this.attitudes,
                    position: this.lat + "/" + this.lon,
                    positionIfBlocked: this.blockedLat + "/" + this.blockedLon,
                    login: localStorage.getItem("userName"),
                    photo: $('#photo').val(),
                    first_name: this.first_name,
                    last_name: this.second_name,
                    gender: this.radio,
                    sexual_pref: this.preferences,
                    biography: this.textarea,
                    hobby: this.textareaCopy,
                    tmpHobbies: this.tmpHobby,
                    birthday: this.selectedDate,
                    city: this.city
                }).then((response) => {
                    if (response.data === 1) {
                        axios.post('http://10.111.4.5:8080/CheckRating/returnRatingAfterFilling', {
                            userLogin: localStorage.getItem("userName")
                        }).then((response) => {
                            localStorage.setItem("rating", response.data)
                        });
                        setTimeout(function () {
                            bus.$emit('stopRenderApp', false);
                            bus.$emit('showMessageEmailConfirmNeed', false);
                            $('html').removeClass('active shadowed');
                            bus.$emit("fillProfile", false);
                            bus.$emit("showResult", true);
                        }, 200);
                    }
                })
                this.textareaCopy = this.tmpHobby;
            },
            postFirstName() {
                axios.post('http://10.111.4.5:8080/UserProfile/ajaxCheck', {
                    firstName: this.first_name
                })
                    .then((response) => {
                        this.answer = response.data
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            postSecondName() {
                axios.post('http://10.111.4.5:8080/UserProfile/ajaxCheck', {
                    secondName: this.second_name
                }).then((response) => {
                    this.answer_2 = response.data
                }).catch(function (error) {
                    console.log(error);
                });
            }
        },
        mounted() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(this.showPosition);
            }
            axios.get('http://ip-api.com/json').then((response) => {
                this.blockedLat = response.data.lat,
                    this.blockedLon = response.data.lon
                    this.city = response.data.city
            })
        },
        created() {
            if (localStorage.getItem("rating") >= 60) {
                bus.$emit("showResult", true);
                this.seen = false;
            }
            else {
                bus.$emit("showResult", false);
                this.seen = true;
            }
            axios.post('http://10.111.4.5:8080/CheckRating/checkRating', {
                login: localStorage.getItem("userName")
            }).then((response) => {
                if (response.data === false) {
                    bus.$emit("showResult", true);
                    bus.$emit("fillProfile", false);
                }
            })
        }
    }
</script>

<style scoped>
    body {
        font-family: Verdana, Geneva, sans-serif;
        font-size: 14px;
        background: #f2f2f2;
    }
    .sliderDivP {
        margin-left: -210px;
    }

    .sliderDivValue {
        color: grey;
        margin-top: -12px;
        margin-left: -230px;
        margin-bottom: 5px;
    }
    .attitudes {
        display: flex;
        flex-direction: column;
        justify-content: center;
        border: 1px solid #cccccc;

    }

    .attitudes .md-radio {
        margin-left: 10px;
        margin-top: -10px;

    }

    .attitudes p {
        display: flex;
        justify-content: center;
    }

    .md-option {
        font-size: 12px !important;
    }

    .for-mobile {
        position: relative;
        width: 100%;
        height: 100%;
        margin-top: 370px
    }

    .clearfix:after {
        content: "";
        display: block;
        clear: both;
        visibility: hidden;
        height: 0;
    }

    .form_wrapper {
        background-color: white;
        width: 320px;
        max-width: 100%;
        box-sizing: border-box;
        padding: 25px;
        top: 50%;
        left: 50%;
        margin-top: -295px;
        margin-left: -160px;
        position: absolute;
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
        font-size: 1.5em;
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
        margin-bottom: 10px;
        -webkit-transition: all 0.3s ease-in-out;
        -moz-transition: all 0.3s ease-in-out;
        -ms-transition: all 0.3s ease-in-out;
        transition: all 0.3s ease-in-out;
    }

    ul,
    li {
        list-style-type: none;
        margin: 0 !important;
        padding: 0;
    }

    .button:hover {
        background: #e1a70a;
    }

    .button:focus {
        background: #e1a70a;
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

    .choose_sexual_pref {
        position: relative;
        width: 100%;
        display: block;
        height: 32px;
        font-size: 14px;
        border: 1px solid #cccccc;
        background-color: white;
    }

    textarea {
        position: relative;
        width: 98%;
        height: 100px;
        display: block;
        font-size: 14px;
        border: 1px solid #cccccc;
        resize: none;
    }

    .foto {
        display: flex;
        justify-content: center;
        margin-bottom: 40px;
    }

    .icon_foto_big {
        width: 130px;
        height: 100px
    }

</style>
