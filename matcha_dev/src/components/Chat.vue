<template>
    <div id="noMessages">
             <video id="ebat" style="display:none;margin-top: 100px;" loop="loop" autoplay>
             <source src="http://10.111.4.5:8080/video/syslik.mp4" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"'>
                </video>
        <div id="wrapper">
            <div class="message-container">
                <div class="message-north">
                    <ul class="message-user-list">
                        <li v-for="item in chat">
                            <a v-bind:id="item.login" v-if="item.login" v-on:click="chooseChat(item.login)">
                                <span class="user-img"><md-avatar><img v-bind:src="item.avatar"></md-avatar></span>
                                <span class="user-title">{{ item.name }}</span>
                                <div v-show="item.isActiveNotifications" class="notifications-chat"><span
                                        class="notification-counter-span-chat">{{ item.msgCnt }}</span></div>
                                <p class="user-desc">{{ item.login }}</p>
                            </a>
                        </li>
                    </ul>
                    <input id="userLogin" type="hidden">
                    <div id="textMessages" class="message-thread" v-html="message"></div>
                </div>
                <div class="message-south">
                    <textarea v-on:input="isTypingAction" id="messageToSend" cols="20" rows="3"></textarea>
                    <button id="send">Send</button>
                    <md-button id="back" style="float: left; display: none" v-on:click="backToUserList">
                        <md-icon class="fas fa-arrow-left"></md-icon>
                    </md-button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import axios from 'axios'
    import decode from 'jwt-decode'
    import {bus} from '../js/bus.js'

    export default {

        name: 'Chat',
        data: function () {
            return {
                login: '',
                message: '',
                chat: {}
            }
        },
        methods: {
            backToUserList() {
                $('.message-container > .message-north > .message-thread').css('display', 'none');
                $('.message-container > .message-north > .message-user-list').css('display', 'block');
                $('.message-container > .message-north > .message-user-list a').css('display', 'block');
                $('.message-south').css('display', 'none');
                $('#back').css('display', 'none');
                var send = JSON.parse(decode(localStorage.getItem("userName")));
                const socket = io('http://10.111.4.5:8083');
                socket.emit('is reading', [send.name, $('#userLogin').val(), 'Seen']);
                axios.post('http://10.111.4.5:8080/SaveSendMessage/changeSeenStatus', {
                    myLogin: send.name,
                    hisLogin: $('#userLogin').val()
                }).then((response) => {

                }).catch(function (error) {
                    console.log(error);
                })
                let login = $('#userLogin').val();
                document.getElementById(login).childNodes[2].style.display = "none";
                $('#userLogin').val("");
            },
            chooseChat(login) {
                if (window.innerWidth <= 1100) {
                    $('.message-container > .message-north > .message-thread').css({
                        'display': 'block',
                        'width': '300px'
                    });
                    $('.message-container > .message-north > .message-user-list').css('display', 'none');
                    $('.message-container > .message-north > .message-user-list a').css('display', 'none');
                    $('.message-south').css({'display': 'block', 'width': '100%'});
                    $('#back').css('display', 'block');
                }
                $('.message-thread').animate({
                    scrollTop: $('.message-thread')[0].scrollHeight + 100000
                }, 1000);
                $('#userLogin').val(login);
                axios.post('http://10.111.4.5:8080/GetMessages/getChatWithUser', {
                    login: [localStorage.getItem("userName"), login]
                }).then((response) => {
                    this.message = response.data.messages
                    this.login = response.data.login
                })

                var send = JSON.parse(decode(localStorage.getItem("userName")));
                const socket = io('http://10.111.4.5:8083');
                socket.emit('is reading', [send.name, $('#userLogin').val(), 'Seen']);
                axios.post('http://10.111.4.5:8080/SaveSendMessage/changeSeenStatus', {
                    myLogin: send.name,
                    hisLogin: $('#userLogin').val()
                }).then((response) => {

                }).catch(function (error) {
                    console.log(error);
                })
                document.getElementById(login).childNodes[2].style.display = "none";
            },
            isTypingAction() {
                const socket = io('http://10.111.4.5:8083');
                const body = [localStorage.getItem("userName"), $('#userLogin').val(), "is typing..."];
                socket.emit('is typing', body);
            }
        },
        mounted() {
            var video = document.getElementById("ebat");
            video.pause();
            //Send message
            $('#send').on('click', function () {
                if (/^\s+$/.test(document.getElementById("messageToSend").value) || document.getElementById("messageToSend").value == "") {
                    return;
                }
                if (document.getElementsByClassName('seen-or-not')[0]) {
                    var elem = document.getElementsByClassName('seen-or-not')[0];
                    elem.remove();
                }
                var name = JSON.parse(decode(localStorage.getItem("userName")));

                var div = document.createElement('div');
                var text = document.createElement('p');
                var label = document.createElement('label');
                var span = document.createElement('span');

                span.classList.add('seen-or-not');
                span.innerText = "Delivered";
                label.innerText = name.name;
                text.innerText = document.getElementById("messageToSend").value;
                div.classList.add('message');
                div.classList.add('bubble-right');
                label.classList.add('message-user');

                let foundPlace = $('.message-thread')[0];

                foundPlace.appendChild(div);
                div.appendChild(label);
                div.appendChild(text);
                foundPlace.appendChild(span);

                $('.message-thread').animate({
                    scrollTop: $('.message-thread')[0].scrollHeight + 100000
                }, 1000);
                const socket = io('http://10.111.4.5:8083');
                const body = [localStorage.getItem("userName"), $('#userLogin').val(), $('#messageToSend').val()];
                socket.emit('message send', body);
                $('#messageToSend').val("");

                //Check if user looking this chat
                const array = [localStorage.getItem("userName"), $('#userLogin').val()];
                socket.emit('reading chat', array);
            });

            //Scroll to the last message
            $('.message-thread').animate({
                scrollTop: $('.message-thread')[0].scrollHeight + 100000
            }, 1000);

            $('#wrapper').css('display', 'none');
            //First thing first get all users on left bar
            axios.post('http://10.111.4.5:8080/GetMessages/returnMessages', {
                login: localStorage.getItem("userName")
            }).then((response) => {
                if (response.data !== "empty") {
                    this.chat = response.data
                    $('#wrapper').css('display', 'block');
                    if (this.chat.length > 0) {
                        this.login = this.chat[0].login;
                        this.message = this.chat[0].messages;
                        $('#userLogin').val(this.login);

                        //Send message
                        const socket = io('http://10.111.4.5:8083');

                        //If user open messages component
                        var send = JSON.parse(decode(localStorage.getItem("userName")));
                        if (window.innerWidth > 1100) {
                            socket.emit('is reading', [send.name, $('#userLogin').val(), 'Seen']);
                            axios.post('http://10.111.4.5:8080/SaveSendMessage/changeSeenStatus', {
                                myLogin: send.name,
                                hisLogin: $('#userLogin').val()
                            }).then((response) => {
                                var hisName = document.getElementById('userLogin').value;
                                if (document.getElementById(hisName)) {
                                    document.getElementById(hisName).childNodes[2].style.display = "none";
                                }
                            }).catch(function (error) {
                                console.log(error);
                            })
                        }
                    }
                }
                else {
                    var video = document.getElementById("ebat");
                    const playPromise = video.play();
                        this.$toast.error({
                            title: 'No messages yet',
                            message: 'Sorry you have no matches :('
                        })
                        if (window.innerWidth < 1100) {
                            $('#wrapper').css('display', 'none');
                            document.getElementById('send').setAttribute('disabled', 'disabled');
                            $('#ebat').css('display', 'block');
                        } else {
                            if (playPromise !== null){
                                playPromise.then(() => { video.pause(); })
                                $('#wrapper').css('display', 'block');
                                document.getElementById('send').setAttribute('disabled', 'disabled');
                            }
                        }
                        return;
                }
            }).catch(function (error) {
                console.log(error);
            });

            //Send message
            const socket = io('http://10.111.4.5:8083');

            socket.on('message send', (msg) => {
                var myName = JSON.parse(decode(localStorage.getItem("userName")));
                if (msg.matchThisName === myName.name) {
                    if (msg.from === $('#userLogin').val()) {
                        if ($('.message-thread')[0]) {
                            $('.message-thread').animate({
                                scrollTop: $('.message-thread')[0].scrollHeight
                            }, 1000);
                        }
                        this.message = msg.message;
                    }
                }
            });

            //Typing action
            socket.on('is typing', (msg) => {
                var myName = JSON.parse(decode(localStorage.getItem("userName")));
                if (msg.name === myName.name) {
                    if (document.getElementById(msg.whoIsTyping)) {
                        document.getElementById(msg.whoIsTyping).lastChild.innerText = msg.whoIsTyping + " is typing...";
                        setTimeout(function () {
                            if (document.getElementById(msg.whoIsTyping)) {
                                document.getElementById(msg.whoIsTyping).lastChild.innerText = msg.whoIsTyping;
                            }
                        }, 3000);
                    }
                }
            });

            //Read now chat with me or not
            socket.on('reading chat', (msg) => {
                var decodedName = JSON.parse(decode(localStorage.getItem("userName")));
                var myName = msg[1];
                var hisName = JSON.parse(decode(msg[0]));
                if (myName === decodedName.name) {
                    if ($('#userLogin').val() === hisName.name) {
                        socket.emit('is reading', [decodedName.name, hisName.name, 'Seen']);
                        axios.post('http://10.111.4.5:8080/SaveSendMessage/changeSeenStatus', {
                            myLogin: decodedName.name,
                            hisLogin: $('#userLogin').val()
                        }).then((response) => {


                        }).catch(function (error) {
                            console.log(error);
                        })
                    }
                    else {
                        socket.emit('is reading', [decodedName.name, hisName.name, 'Delivered']);
                    }
                }
            });

            // Catch that user is reading my chat
            socket.on('is reading', (msg) => {
                var decodedName = JSON.parse(decode(localStorage.getItem("userName")));
                if (decodedName.name === msg[1]) {
                    if ($('#userLogin').val() === msg[0]) {
                        if (document.getElementsByClassName('seen-or-not')[0]) {
                            var elem = document.getElementsByClassName('seen-or-not')[0];
                            elem.remove();
                            var span = document.createElement('span');
                            span.classList.add('seen-or-not');
                            span.innerText = msg[2];
                            let foundPlace = $('.message-thread')[0];
                            foundPlace.appendChild(span);
                        }
                    }
                }
            })
        }
    }
</script>

<style>
    .notifications-chat {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 20px;
        height: 20px;
        background: red;
        border-radius: 50%;
        margin-left: 25px;
        margin-top: 0px;
        position: absolute;
    }

    .notification-counter-span-chat {
        position: absolute;
        z-index: 7;
        color: white;
        font-size: 10px;
    }

    .seen-or-not {
        margin-left: 425px !important;
        font-size: 10px;
        font-style: italic;
    }

    .isTyping {
        font-size: 10px;
        font-style: italic;
    }

    #wrapper {
        margin-top: 100px;
    }

    .bubble-left {
        word-wrap: break-word;
        float: left;
        clear: both;
        background: #B7CC90;
    }

    .bubble-left:hover {
        background: #A9C07F;
    }

    .bubble-left:before {
        content: " ";
        display: block;
        position: relative;
        top: 0px;
        left: -11px;
        height: 13px;
        width: 13px;
        background: inherit; /*#B7CC90*/
        z-index: 100;

        -webkit-transform: rotate(-45deg);
        -moz-transform: rotate(-45deg);
        -o-transform: rotate(-45deg);
        transform: rotate(-45deg);
    }

    .bubble-right {
        word-wrap: break-word;
        float: right;
        clear: both;
        text-align: right;
        background: #90B2CC;;
    }

    .bubble-right:hover {
        background: #82A6C1;
    }

    .bubble-right:before {
        content: " ";
        display: block;
        position: relative;
        top: 0px;
        right: -99.8%;
        height: 13px;
        width: 13px;
        background: inherit; /*#90B2CC*/

        -webkit-transform: rotate(-45deg);
        -moz-transform: rotate(-45deg);
        -o-transform: rotate(-45deg);
        transform: rotate(-45deg);
    }

    .message-container {
        display: block;
        margin: auto;
        margin-top: 2.5%;
        height: 620px; /*Global Height of Widget*/
        width: 1000px; /*Global Width of Widget*/
        background: #E1E1E1;
        box-shadow: 0px 0px 50px #1E1E1E;
    }

    .message-container > .message-north {
        width: 100%;
        height: 80%;

        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }

    .message-container > .message-south {
        width: 77.5%;
        height: 20%;
        padding: 1%;
        float: right;

        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }

    .message-container > .message-north > .message-user-list {
        list-style-type: none;
        float: left;
        clear: left;
        width: 25%;
        height: 100%;
        overflow-x: hidden;
        overflow-y: scroll;
    }

    .message-container > .message-north > .message-user-list a {
        display: block;
        padding: 10px;
        width: 250px;
        height: 60px;
        cursor: pointer;
        /*height: 40px; Keep height same as img thumbnail height*/
        text-decoration: none;
        color: #313131;

        -webkit-transition: all ease .2s;
        -moz-transition: all ease .2s;
        -ms-transition: all ease .2s;
        -o-transition: all ease .2s;
        transition: all ease .2s;
    }

    .message-container > .message-north > .message-user-list a:hover {
        background: #9E9E9E;

        -webkit-transition: all ease .2s;
        -moz-transition: all ease .2s;
        -ms-transition: all ease .2s;
        -o-transition: all ease .2s;
        transition: all ease .2s;
    }

    .message-container > .message-north > .message-user-list a .user-img {
        display: block;
        float: left;
        height: 40px;
        width: 40px;
    }

    .message-container > .message-north > .message-user-list a .user-title {
        margin-left: 5px;
    }

    .message-container > .message-north > .message-user-list a.active {
        background: #BFBFBF;
    }

    .message-container > .message-north > .message-user-list a.highlight {
        background: #90B2CC;
    }

    .message-container > .message-north > .message-user-list a.highlight .user-title {
        font-weight: bold;
    }

    .message-container > .message-north > .message-thread {
        float: right;
        width: 75%;
        height: 100%;
        padding-left: 10px;
        padding-right: 10px;
        background: #F5F5F5;
        overflow-x: hidden;
        overflow-y: scroll;

        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }

    @media only screen and (min-width: 1100px) {
        .seen-or-not {
            margin-left: 425px !important;
            font-size: 10px;
            font-style: italic;
        }

        .message-container {
            display: block;
            margin: auto;
            margin-top: 2.5%;
            height: 620px; /*Global Height of Widget*/
            width: 1000px; /*Global Width of Widget*/
            background: #E1E1E1;
            box-shadow: 0px 0px 50px #1E1E1E;
        }

        .message-container > .message-north > .message-thread {
            float: right;
            width: 75%;
            height: 100%;
            padding-left: 10px;
            padding-right: 10px;
            background: #F5F5F5;
            overflow-x: hidden;
            overflow-y: scroll;

            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        .message-container > .message-north > .message-user-list {
            list-style-type: none;
            float: left;
            clear: left;
            width: 25%;
            height: 100%;
            overflow-x: hidden;
            overflow-y: scroll;
        }

        .message-container > .message-north > .message-user-list a {
            width: 250px;
        }

        .message-south {
        }
    }

    @media only screen and (max-width: 1100px) {
        .seen-or-not {
            margin-left: 155px !important;
            font-size: 10px;
            font-style: italic;
        }

        .message-container {
            display: block;
            margin: auto;
            margin-top: 2.5%;
            height: 620px; /*Global Height of Widget*/
            width: 300px; /*Global Width of Widget*/
            background: #E1E1E1;
            box-shadow: 0px 0px 50px #1E1E1E;
        }

        .message-container > .message-north > .message-thread {
            display: none;
            float: right;
            width: 75%;
            height: 100%;
            padding-left: 10px;
            padding-right: 10px;
            background: #F5F5F5;
            overflow-x: hidden;
            overflow-y: scroll;

            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        .message-container > .message-north > .message-user-list {
            list-style-type: none;
            float: left;
            clear: left;
            width: 300px;
            height: 125%;
            overflow-x: hidden;
            overflow-y: scroll;
        }

        .message-container > .message-north > .message-user-list a {
            width: 300px;
        }

        .message-south {
            display: none;
        }
    }

    .message-container > .message-north > .message-thread > .message {
        min-width: 40%;
        max-width: 70%;
        margin: 5px;
        margin-bottom: 2%;
        padding: 3px 5px 3px 5px;
        cursor: pointer;
    }

    .message-container > .message-north > .message-thread > .message > p {
        display: block;
        clear: both;
        margin-left: 3px;
        margin-right: 3px;
        font-size: 15px;
    }

    .message-container > .message-north > .message-thread > .message label {
        margin-top: -13px;
        font-size: 13px;
        font-weight: bold;
        color: #5A5A5A;
        cursor: pointer;
    }

    .message-container > .message-north > .message-thread > .message .message-user {
        display: block;
        float: left;
        margin-left: 3px;
    }

    .message-container > .message-north > .message-thread > .message .message-timestamp {
        display: block;
        float: right;
        margin-right: 3px;
        text-align: right;
    }

    .message-container > .message-south > textarea {
        width: 100%;
        height: 65%;
        padding: 7px 10px;

        outline: none;
        resize: none;
        font-size: 13px;
        color: #666;
        background: #f6f6f6;
        border: 1px solid #b9b9b9;
        border-top-color: #a4a4a4;
        box-shadow: 0 1px 1px rgba(0, 0, 0, .17) inset;

        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }

    .message-container > .message-south > textarea:focus {
        background: #FFF;
    }

    .message-container > .message-south > button {
        display: inline-block;
        float: right;
        margin-top: 0px;
        height: 35px;
        width: 80px;
        color: #000000;
        background: -webkit-linear-gradient(#F5F5F5, #E9E9E9);
        background: -moz-linear-gradient(#F5F5F5, #E9E9E9);
        background: -o-linear-gradient(#F5F5F5, #E9E9E9);
        background: linear-gradient(#F5F5F5, #E9E9E9);
        border: 2px solid #CCC;
        box-shadow: 0px 1px 2px #C6C6C6;
        cursor: pointer;
    }

    .message-container > .message-south > button:hover {
        background: -webkit-linear-gradient(#FFFFFF, #DFDFDF);
        background: -moz-linear-gradient(#FFFFFF, #DFDFDF);
        background: -o-linear-gradient(#FFFFFF, #DFDFDF);
        background: linear-gradient(#FFFFFF, #DFDFDF);
    }

    .message-container > .message-south > button:active {
        box-shadow: inset 0px 0px 10px #5A5A5A;
        background: -webkit-linear-gradient(#E9E9E9, #F5F5F5);
        background: -moz-linear-gradient(#E9E9E9, #F5F5F5);
        background: -o-linear-gradient(#E9E9E9, #F5F5F5);
        background: linear-gradient(#E9E9E9, #F5F5F5);
    }

    .message-container > .message-north > .message-user-list a .user-desc {
        padding-left: 6px;
        /*padding-top: 5px;*/
        margin-top: -5px;
        font-size: 12px;
        color: #5A5A5A;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>


