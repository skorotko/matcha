<template>
    <div>

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css"
              integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ"
              crossorigin="anonymous">
        <div id="header">
            <slot v-cloak></slot>
        </div>
        <div id="bottom-bar">
            <md-button class="md-icon-button" v-on:click="backHome">
                <md-icon class="fas fa-home"></md-icon>
            </md-button>

            <md-button class="md-icon-button" v-on:click="toggleMobile">
                <md-icon>notifications</md-icon>
                <div v-if="showNotifications" class="notifications-mobile"><span
                        class="notification-counter-span">{{ notifications }}</span></div>
            </md-button>

            <md-menu md-size="big" md-direction="bottom-end" :md-active.sync="toggleCardMobile">
                <md-menu-content>
                    <ul id="notificationMessagesMobile" v-html="notificationMessages"></ul>
                </md-menu-content>
            </md-menu>

            <md-button class="md-icon-button" v-on:click="displayMessageComponent">
                <md-icon class="fas fa-envelope"></md-icon>
                <div v-if="showMessages" class="notifications-mobile"><span
                        class="notification-counter-span">{{ messages }}</span></div>
            </md-button>

            <md-button class="md-icon-button" v-on:click="showCabinet">
                <md-icon class="fas fa-user"></md-icon>
            </md-button>
            <md-button class="md-icon-button"
                       v-on:click="changeSearchType">
                <md-icon class="fas fa-search"></md-icon>
            </md-button>
            <md-button class="md-icon-button" v-on:click="logout">
                <md-icon class="fas fa-sign-out-alt"></md-icon>
            </md-button>
        </div>
        <div>
            <md-app>
                <md-app-drawer md-permanent="card" style="width:70px; height: 340px; margin-top: 70px;margin-left:5px">
                    <md-button class="md-icon-button" style="margin-left: 11px;margin-bottom: -15px;margin-top: 22px;"
                               v-on:click="backHome">
                        <md-icon class="fas fa-home"></md-icon>
                    </md-button>


                    <md-button class="md-icon-button button-position" v-on:click="toggle">
                        <md-icon>notifications</md-icon>
                    </md-button>
                    <div v-if="showNotifications" class="notifications"><span
                            class="notification-counter-span">{{ notifications }}</span></div>


                    <md-menu md-size="big" md-direction="bottom-start" :md-active.sync="toggleCard">

                        <md-menu-content>
                            <ul id="notificationMessages" v-html="notificationMessages"></ul>
                        </md-menu-content>
                    </md-menu>


                    <md-button class="md-icon-button button-position" v-on:click="displayMessageComponent">
                        <img src="../images/convert.svg">
                    </md-button>
                    <div v-if="showMessages" class="notifications"><span class="notification-counter-span">{{ messages
                        }}</span></div>


                    <md-button class="md-icon-button" style="margin-left: 13px; margin-top: 22px"
                               v-on:click="showCabinet">
                        <md-icon class="fas fa-user"></md-icon>
                    </md-button>
                    <md-button class="md-icon-button" style="margin-left: 13px; margin-top: 15px"
                               v-on:click="changeSearchType">
                        <md-icon class="fas fa-search"></md-icon>
                    </md-button>

                    <md-button v-on:click="logout" class="md-icon-button" style="margin-left: 16px; margin-top: 12px">
                        <md-icon class="fas fa-sign-out-alt"></md-icon>
                    </md-button>
                </md-app-drawer>
                <md-app-content>


                    <chat v-if="chat"></chat>

                    <div style="margin-top:80px;">
                        <cabinet v-if="changePersonalData"></cabinet>
                        <advanced-search v-if="advancedSearch"></advanced-search>
                        <div v-if="forAdvancedSearch" class="sort-and-filter">
                            <div class="viewport">
                                <md-toolbar :md-elevation="5">
                                    <span class="md-title">Filter</span>
                                </md-toolbar>
                                <md-list class="md-double-line">
                                    <div class="sliderPos">
                                        <div class="sliderDiv">
                                            <p> Max. distance(km)</p>
                                            <vue-slider v-model="geolocation.value" class="mobile-range"
                                                        v-bind="geolocation"></vue-slider>
                                        </div>
                                        <div class="sliderDiv">
                                            <p>Select age range</p>
                                            <vue-slider v-model="ageOptions.value" class="mobile-range"
                                                        v-bind="ageOptions"></vue-slider>
                                        </div>
                                        <div class="sliderDiv">
                                            <p>Rating</p>
                                            <vue-slider v-model="fameRating.value" class="mobile-range"
                                                        v-bind="fameRating"></vue-slider>
                                        </div>


                                        <textarea id="hash_tags" v-bind="hash" v-model="area" cols="30" rows="10"
                                                  placeholder="Filter by #hashtags..."></textarea>

                                        <md-button class="md-raised md-primary"
                                                   v-on:click="filter(geolocation.value, ageOptions.value, fameRating.value)">
                                            show
                                        </md-button>
                                        <md-button class="md-raised md-primary margin-button" v-on:click="reset">
                                            reset all
                                        </md-button>
                                    </div>
                                </md-list>
                            </div>
                            <div class="viewport">
                                <md-toolbar :md-elevation="5">
                                    <span class="md-title">Sort</span>
                                </md-toolbar>
                                <md-list class="md-double-line">
                                    <div class="chips">
                                        <md-chip class="md-primary" v-for="chip in sortList" :key="chip.id" md-clickable
                                                 v-on:click="sortByChoosen(chip.id)">
                                            {{ chip.message }}
                                        </md-chip>
                                    </div>
                                </md-list>
                            </div>
                        </div>

                        <div style="margin-top: 70px">
                            <div v-if="filterResult" class='resultDiv' v-for="item in filterCards">
                                <md-card :id="item.newid">
                                    <md-card-media>
                                        <md-ripple>
                                            <div>
                                                <md-dialog :md-active.sync="item.seen">
                                                    <div class="content-div">
                                                        <img v-bind:src="item.photo" class="content-img">
                                                        <div v-if="item.onlineStatus"
                                                             style="margin-left: -130px;font-style: italic">
                                                            <span style="float: left;"><img src="../images/online.png"
                                                                                            class="online"></span>
                                                            <span>Online</span>
                                                        </div>
                                                        <div v-else style="margin-left: -130px;font-style: italic">
                                                            <span style="float: left;"><img src="../images/offline.png"
                                                                                            class="offline"></span>
                                                            <span>Offline</span><br>
                                                            <span class="offline">{{ item.logoutTime }}</span>
                                                        </div>
                                                    </div>
                                                    <md-tabs md-dynamic-height md-dynamic-width md-alignment="centered"
                                                             style="margin-bottom: -35px; max-width: 500px;">
                                                        <md-tab md-label="About me">
                                                            <p class="about-me">
                                                                Biography: {{ item.biography }}
                                                            <p class="about-me-p">I`m {{ item.birthday
                                                                }} years old and my login is {{ item.login
                                                                }}. I`m from {{ item.city }}.</p>
                                                            <p class="about-me-p">You can find me by interests: <span
                                                                    v-if="item.interests"
                                                                    v-for="items in item.interests">{{ items }} </span>
                                                            </p>
                                                            <p class="about-me-p" v-if="item.children == 0">
                                                                I have no children.</p>
                                                            <p class="about-me-p" v-else>I have children.</p>
                                                            <p class="about-me-p" v-if="item.education == 0">
                                                                I have no education.</p>
                                                            <p class="about-me-p" v-else>I have higher education.</p>
                                                            <p class="about-me-p">My height is {{ item.height }}.</p>
                                                            <p class="about-me-p"> My rating is {{ item.rating }}.</p>
                                                            <p class="about-me-p">Distance to you: {{ item.distance
                                                                }} km</p>
                                                            </p>
                                                        </md-tab>
                                                        <md-tab md-label="Photos" style="margin-top: 40px;">
                                                            <md-content
                                                                    style="width:100%; height: 200px;display:flex; justify-content:center;">
                                                                <div v-if="item.photos.length"
                                                                     v-html="item.photos"></div>
                                                            </md-content>
                                                        </md-tab>

                                                    </md-tabs>
                                                    <md-dialog-actions>
                                                        <md-button class="md-primary" style="margin-top: 10px"
                                                                   v-on:click="item.seen = false">
                                                            Close
                                                        </md-button>
                                                        <md-button class="md-primary" style="margin-top: 10px"
                                                                   v-if="item.fake"
                                                                   v-on:click="fakeAccount(item)">
                                                            Fake account
                                                        </md-button>
                                                        <md-button :disabled="item.block" id="block_user"
                                                                   class="md-primary" style="margin-top: 10px"
                                                                   v-bind:value="item.login"
                                                                   v-on:click="blockUser(item);">
                                                            Block user
                                                        </md-button>
                                                    </md-dialog-actions>
                                                </md-dialog>
                                            </div>
                                            <div v-on:click="item.seen = true">
                                                <img class="photoClass" v-bind:src="item.photo" alt='People'
                                                     v-on:click="viewProfileAction(item.login)">
                                            </div>
                                        </md-ripple>
                                    </md-card-media>
                                    <md-card-header>
                                        <div class="md-title">{{ item.first_name }} {{ item.last_name }}</div>
                                    </md-card-header>
                                    <md-card-actions>
                                        <div v-on:click="item.isActive = !item.isActive">
                                            <md-button v-if="item.isActive"
                                                       class='md-icon-button'
                                                       v-on:click="likeAction(item.login)">
                                                <md-icon>favorite</md-icon>
                                            </md-button>
                                            <md-button v-if="!item.isActive" class='md-icon-button'
                                                       v-on:click="dislikeAction(item.login)">
                                                <img class="dislike" src="../images/dislike.png" alt="">
                                            </md-button>
                                        </div>
                                        <div v-on:click="item.seen = true">
                                            <md-button class='md-icon-button'
                                                       v-on:click="viewProfileAction(item.login)">
                                                <md-icon class='fas fa-user'>
                                                </md-icon>
                                            </md-button>
                                        </div>
                                    </md-card-actions>
                                </md-card>
                            </div>
                        </div>


                        <div style="margin-top: 70px">
                            <div v-if="seen" v-model="userCards" class='resultDiv' v-for="item in userCards">
                                <md-card :id="item.newid">
                                    <md-card-media>
                                        <md-ripple>
                                            <div>
                                                <md-dialog :md-active.sync="item.seen">
                                                    <div class="content-div">
                                                        <img v-bind:src="item.photo" class="content-img">
                                                        <div v-if="item.onlineStatus"
                                                             style="margin-left: -130px;font-style: italic">
                                                            <span style="float: left;"><img src="../images/online.png"
                                                                                            class="online"></span>
                                                            <span>Online</span>
                                                        </div>
                                                        <div v-else style="margin-left: -130px;font-style: italic">
                                                            <span style="float: left;"><img src="../images/offline.png"
                                                                                            class="offline"></span>
                                                            <span>Offline</span><br>
                                                            <span class="offline">{{ item.logoutTime }}</span>
                                                        </div>
                                                    </div>
                                                    <md-tabs md-dynamic-height md-alignment="centered"
                                                             style="margin-bottom: -35px; max-width: 500px;">
                                                        <md-tab md-label="About me">
                                                            <p class="about-me">
                                                                Biography: {{ item.biography }}
                                                            <p class="about-me-p" style="line-height: 0.9;">
                                                                I`m {{ item.birthday
                                                                }} years old and my login is {{ item.login
                                                                }}. I`m from {{ item.city }}.</p>
                                                            <p class="about-me-p">You can find me by interests: <span
                                                                    v-if="item.interests"
                                                                    v-for="items in item.interests">{{ items }} </span>
                                                            </p>
                                                            <p class="about-me-p" v-if="item.children == 0">
                                                                I have no children.</p>
                                                            <p class="about-me-p" v-else>I have children.</p>
                                                            <p class="about-me-p" v-if="item.education == 0">
                                                                I have no education.</p>
                                                            <p class="about-me-p" v-else>I have higher education.</p>
                                                            <p class="about-me-p">My height is {{ item.height }}.</p>
                                                            <p class="about-me-p">My rating is {{ item.rating }}.</p>
                                                            <p class="about-me-p">Distance to you: {{ item.distance
                                                                }} km</p>
                                                            </p>
                                                        </md-tab>
                                                        <md-tab md-label="Photos" style="margin-top: 40px;">
                                                            <md-content
                                                                    style="height: 200px;display:flex; justify-content:center;">
                                                                <div v-if="item.photos.length"
                                                                     v-html="item.photos"></div>
                                                            </md-content>
                                                        </md-tab>

                                                    </md-tabs>
                                                    <md-dialog-actions>
                                                        <md-button class="md-primary" style="margin-top: 10px"
                                                                   v-on:click="item.seen = false">
                                                            Close
                                                        </md-button>
                                                        <md-button class="md-primary" style="margin-top: 10px"
                                                                   v-if="item.fake"
                                                                   v-on:click="fakeAccount(item)">
                                                            Fake account
                                                        </md-button>
                                                        <md-button :disabled="item.block" id="block_user"
                                                                   class="md-primary" style="margin-top: 10px"
                                                                   v-bind:value="item.login"
                                                                   v-on:click="blockUser(item);">
                                                            Block user
                                                        </md-button>
                                                    </md-dialog-actions>
                                                </md-dialog>
                                            </div>
                                            <div v-on:click="item.seen = true">
                                                <img class="photoClass" v-bind:src="item.photo" alt='People'
                                                     v-on:click="viewProfileAction(item.login)">
                                            </div>
                                        </md-ripple>
                                    </md-card-media>
                                    <md-card-header>
                                        <div class="md-title">{{ item.first_name }} {{ item.last_name }}</div>
                                    </md-card-header>
                                    <md-card-actions>
                                        <div v-on:click="item.isActive = !item.isActive">
                                            <md-button v-if="item.isActive"
                                                       class='md-icon-button'
                                                       v-on:click="likeAction(item.login)">
                                                <md-icon>favorite</md-icon>
                                            </md-button>
                                            <md-button v-if="!item.isActive" class='md-icon-button'
                                                       v-on:click="dislikeAction(item.login)">
                                                <img class="dislike" src="../images/dislike.png" alt="">
                                            </md-button>
                                        </div>
                                        <div v-on:click="item.seen = true">
                                            <md-button class='md-icon-button'
                                                       v-on:click="viewProfileAction(item.login)">
                                                <md-icon class='fas fa-user'>
                                                </md-icon>
                                            </md-button>
                                        </div>
                                    </md-card-actions>
                                </md-card>
                            </div>
                        </div>
                    </div>
                </md-app-content>
            </md-app>
        </div>
    </div>
</template>

<script>
    import * as Three from 'three'
    import Geocoder from 'geocoder'
    import {bus} from '../js/bus.js'
    import axios from 'axios'
    import decode from 'jwt-decode'
    import AdvancedSearch from './AdvancedSearch.vue'
    import Chat from './Chat.vue'
    import VueSlider from 'vue-slider-component'
    import Cabinet from './PersonalCabinet.vue'

    export default {
        name: 'ThreeTest',
        data: function () {
            return {
                fake: true,
                notificationMessages: '',
                changePersonalData: false,
                toggleCardMobile: false,
                toggleCard: false,
                showNotifications: false,
                notifications: 0,
                showMessages: false,
                messages: 0,
                chat: false,
                advancedSearch: false,
                forAdvancedSearch: true,
                distance: true,
                age: true,
                rating: true,
                tags: true,
                filterResult: false,
                seen: true,
                userCards: [],
                filterCards: [],
                area: '',
                sendTags: null,
                sortList: [
                    {message: 'Distance', id: 'distance'},
                    {message: 'Age', id: 'age'},
                    {message: 'Rating', id: 'rating'},
                    {message: 'Tags', id: 'tags'}
                ],
                ageOptions: {
                    value: [18, 23],
                    width: "200px",
                    height: 8,
                    dotSize: 20,
                    min: 18,
                    max: 55,
                    disabled: false,
                    show: true,
                    tooltip: "always",
                    tooltipDir: [
                        "bottom",
                        "top"
                    ],
                    piecewise: false,
                    style: {
                        "marginTop": "-10px",
                        "marginBottom": "10px"
                    },
                    bgStyle: {
                        "backgroundColor": "#fff",
                        "boxShadow": "inset 0.5px 0.5px 3px 1px rgba(0,0,0,.36)"
                    },
                    sliderStyle: [
                        {
                            "backgroundColor": "#f05b72"
                        },
                        {
                            "backgroundColor": "#3498db"
                        }
                    ],
                    tooltipStyle: [
                        {
                            "backgroundColor": "#f05b72",
                            "borderColor": "#f05b72"
                        },
                        {
                            "backgroundColor": "#3498db",
                            "borderColor": "#3498db"
                        }
                    ],
                    processStyle: {
                        "backgroundImage": "-webkit-linear-gradient(left, #f05b72, #3498db)"
                    }
                },
                geolocation: {
                    value: [1, 5],
                    width: "200px",
                    height: 8,
                    dotSize: 20,
                    min: 1,
                    max: 160,
                    disabled: false,
                    show: true,
                    tooltip: "always",
                    tooltipDir: [
                        "bottom",
                        "top"
                    ],
                    piecewise: false,
                    style: {
                        "marginTop": "-10px",
                        "marginBottom": "10px",
                    },
                    bgStyle: {
                        "backgroundColor": "#fff",
                        "boxShadow": "inset 0.5px 0.5px 3px 1px rgba(0,0,0,.36)"
                    },
                    sliderStyle: [
                        {
                            "backgroundColor": "#f05b72"
                        },
                        {
                            "backgroundColor": "#3498db"
                        }
                    ],
                    tooltipStyle: [
                        {
                            "backgroundColor": "#f05b72",
                            "borderColor": "#f05b72"
                        },
                        {
                            "backgroundColor": "#3498db",
                            "borderColor": "#3498db"
                        }
                    ],
                    processStyle: {
                        "backgroundImage": "-webkit-linear-gradient(left, #f05b72, #3498db)"
                    }
                },
                fameRating: {
                    value: [60, 80],
                    width: "200px",
                    height: 8,
                    dotSize: 20,
                    min: 60,
                    max: 150,
                    disabled: false,
                    show: true,
                    tooltip: "always",
                    tooltipDir: [
                        "bottom",
                        "top"
                    ],
                    piecewise: false,
                    style: {
                        "marginTop": "-10px",
                        "marginBottom": "10px",
                    },
                    bgStyle: {
                        "backgroundColor": "#fff",
                        "boxShadow": "inset 0.5px 0.5px 3px 1px rgba(0,0,0,.36)"
                    },
                    sliderStyle: [
                        {
                            "backgroundColor": "#f05b72"
                        },
                        {
                            "backgroundColor": "#3498db"
                        }
                    ],
                    tooltipStyle: [
                        {
                            "backgroundColor": "#f05b72",
                            "borderColor": "#f05b72"
                        },
                        {
                            "backgroundColor": "#3498db",
                            "borderColor": "#3498db"
                        }
                    ],
                    processStyle: {
                        "backgroundImage": "-webkit-linear-gradient(left, #f05b72, #3498db)"
                    }
                }
            }
        },
        components: {
            VueSlider,
            AdvancedSearch,
            Chat,
            Cabinet
        },
        computed: {
            hash() {
                const parseHashtags = require('parse-hashtags');
                this.sendTags = parseHashtags(this.area);
            }
        },
        methods: {
            fakeAccount(account) {
                this.$toast.success({
                    title: 'Fake Account',
                    message: 'Thank you for report!'
                });
                account.fake = false;
                axios.post('http://10.111.4.5:8080/FakeAccount/sendFakeNotification', {
                    login: account.login
                }).then((response) => {

                }).catch(function (error) {
                    console.log(error)
                })
            },
            showCabinet() {
                if (!this.changePersonalData) {
                    this.forAdvancedSearch = false;
                    this.advancedSearch = false;
                    this.seen = false;
                    this.filterCards = false;
                    this.chat = false;
                    this.changePersonalData = true;
                }
                else {
                    this.forAdvancedSearch = true;
                    this.advancedSearch = false;
                    this.seen = true;
                    this.filterCards = false;
                    this.chat = false;
                    this.changePersonalData = false;
                }
            },
            displayMessageComponent() {
                if (!this.chat) {
                    this.filterResult = false;
                    this.forAdvancedSearch = false;
                    this.advancedSearch = false;
                    this.seen = false;
                    this.filterCards = false;
                    this.chat = true;
                    this.changePersonalData = false;
                    this.resetMessageCounter();
                } else if (this.chat) {
                    this.filterResult = false;
                    this.forAdvancedSearch = true;
                    this.advancedSearch = false;
                    this.seen = true;
                    this.filterCards = false;
                    this.chat = false;
                    this.changePersonalData = false;
                    this.resetMessageCounter();
                }
            },
            readNotifications() {
                axios.post('http://10.111.4.5:8080/ReturnNotificationText/returnNotificationText', {
                    login: localStorage.getItem("userName")
                }).then((response) => {
                    if (response.data === "empty") {
                        this.notificationMessages = "<li>No notifications yet</li>";
                        return;
                    }
                    this.notificationMessages = response.data;
                })
            },
            resetMessageCounter() {
                axios.post('http://10.111.4.5:8080/ResetCounters/messages', {
                    login: localStorage.getItem("userName")
                }).then((response) => {
                })
                this.showMessages = false;
            },
            resetNotifications() {
                axios.post('http://10.111.4.5:8080/ResetCounters/notifications', {
                    login: localStorage.getItem("userName")
                }).then((response) => {
                })
            },
            toggle() {
                this.readNotifications();
                this.resetNotifications();
                this.toggleCard = !this.toggleCard
                this.showNotifications = 0;
            },
            toggleMobile() {
                this.readNotifications();
                this.resetNotifications();
                this.toggleCardMobile = !this.toggleCardMobile
                this.showNotifications = 0;
            },
            likeAction(personName) {
                const socket = io('http://10.111.4.5:8083');
                const body = [localStorage.getItem("userName"), personName];
                socket.emit('like action', body);
            },
            dislikeAction(personName) {
                const socket = io('http://10.111.4.5:8083');
                const body = [localStorage.getItem("userName"), personName];
                socket.emit('dislike action', body);
            },
            viewProfileAction(personName) {
                const socket = io('http://10.111.4.5:8083');
                const body = [localStorage.getItem("userName"), personName];
                socket.emit('view profile action', body);
            },
            backHome() {
                this.changePersonalData = false;
                this.forAdvancedSearch = true;
                this.advancedSearch = false;
                this.seen = true;
                this.filterCards = false;
                this.chat = false;
            },
            changeSearchType() {
                this.changePersonalData = false;
                this.chat = false;
                this.forAdvancedSearch = false;
                this.advancedSearch = true;
                this.seen = false;
                this.filterCards = false;
            },
            sortByChoosen(sortParam) {
                if (this.seen) {
                    if (this.userCards) {
                        if (sortParam === 'tags') {
                            if (!this.tags) {
                                this.tags = !this.tags;
                                this.userCards.sort(function(a,b) {return (a.tags < b.tags) ? 1 : ((b.tags < a.tags) ? -1 : 0);} );
                                return this.userCards
                            }
                            else {
                                this.tags = !this.tags;
                                this.userCards.sort(function(a,b) {return (a.tags > b.tags) ? 1 : ((b.tags > a.tags) ? -1 : 0);} );
                                return this.userCards
                            }
                        }
                        else if (sortParam === 'distance') {
                            if (!this.distance) {
                                this.distance = !this.distance;
                                this.userCards.sort(function(a,b) {return (a.distance > b.distance) ? 1 : ((b.distance > a.distance) ? -1 : 0);} );
                                return this.userCards
                            }
                            else {
                                this.distance = !this.distance;
                                this.userCards.sort(function(a,b) {return (a.distance < b.distance) ? 1 : ((b.distance < a.distance) ? -1 : 0);} );
                                return this.userCards
                            }
                        }
                        else if (sortParam === 'age') {
                            if (!this.age) {
                                this.age = !this.age;
                                this.userCards.sort(function(a,b) {return (a.birthday > b.birthday) ? 1 : ((b.birthday > a.birthday) ? -1 : 0);} );
                                return this.userCards
                            }
                            else {
                                this.age = !this.age;
                                this.userCards.sort(function(a,b) {return (a.birthday < b.birthday) ? 1 : ((b.birthday < a.birthday) ? -1 : 0);} );
                                return this.userCards
                            }
                        }
                        else if (sortParam === 'rating') {
                            if (!this.rating) {
                                this.rating = !this.rating;
                                this.userCards.sort(function(a,b) {return (Number(a.rating) > Number(b.rating)) ? 1 : ((Number(b.rating) > Number(a.rating)) ? -1 : 0);} );
                                return this.userCards
                            }
                            else {
                                this.rating = !this.rating;
                                this.userCards.sort(function(a,b) {return (Number(a.rating) < Number(b.rating)) ? 1 : ((Number(b.rating) < Number(a.rating)) ? -1 : 0);} );
                                return this.userCards
                            }
                        }
                    }
                }
                else {
                    if (this.filterCards) {
                        if (sortParam === 'tags') {
                            if (!this.tags) {
                                this.tags = !this.tags;
                                this.filterCards.sort(function(a,b) {return (a.tags < b.tags) ? 1 : ((b.tags < a.tags) ? -1 : 0);} );
                                return this.filterCards
                            }
                            else {
                                this.tags = !this.tags;
                                this.filterCards.sort(function(a,b) {return (a.tags > b.tags) ? 1 : ((b.tags > a.tags) ? -1 : 0);} );
                                return this.filterCards
                            }
                        }
                        else if (sortParam === 'distance') {
                            if (!this.distance) {
                                this.distance = !this.distance;
                                this.filterCards.sort(function(a,b) {return (a.distance > b.distance) ? 1 : ((b.distance > a.distance) ? -1 : 0);} );
                                return this.filterCards
                            }
                            else {
                                this.distance = !this.distance;
                                this.filterCards.sort(function(a,b) {return (a.distance < b.distance) ? 1 : ((b.distance < a.distance) ? -1 : 0);} );
                                return this.filterCards
                            }
                        }
                        else if (sortParam === 'age') {
                            if (!this.age) {
                                this.age = !this.age;
                                this.filterCards.sort(function(a,b) {return (a.birthday > b.birthday) ? 1 : ((b.birthday > a.birthday) ? -1 : 0);} );
                                return this.filterCards
                            }
                            else {
                                this.age = !this.age;
                                this.filterCards.sort(function(a,b) {return (a.birthday < b.birthday) ? 1 : ((b.birthday < a.birthday) ? -1 : 0);} );
                                return this.filterCards
                            }
                        }
                        else if (sortParam === 'rating') {
                            if (!this.rating) {
                                this.rating = !this.rating;
                                this.filterCards.sort(function(a,b) {return (Number(a.rating) > Number(b.rating)) ? 1 : ((Number(b.rating) > Number(a.rating)) ? -1 : 0);} );
                                return this.filterCards
                            }
                            else {
                                this.rating = !this.rating;
                                this.filterCards.sort(function(a,b) {return (Number(a.rating) < Number(b.rating)) ? 1 : ((Number(b.rating) < Number(a.rating)) ? -1 : 0);} );
                                return this.filterCards
                            }
                        }
                    }
                }
            },
            reset() {
                this.seen = true;
                this.filterResult = false;
                this.ageOptions.value = [18, 18];
                this.geolocation.value = [1, 1];
                this.fameRating.value = [60, 60];
                this.tags = true;
                this.rating = true;
                this.age = true;
                this.distance = true;
                this.area = '';
            },
            filter(geolocation, age, rating) {
                axios.post('http://10.111.4.5:8080/FilterBestMatches/filterBestMatches', {
                    login: localStorage.getItem("userName"),
                    distance: geolocation,
                    age: age,
                    rating: rating,
                    tags: this.sendTags
                }).then((response) => {
                    this.seen = false;
                    if (response.data === "empty") {
                        this.filterResult = false;
                        return;
                    } else {
                        this.filterResult = true;
                    }
                    this.filterCards = response.data;
                    this.filterCards.forEach(function (item, i, arr) {
                        if (item['photos'].length) {
                            let tmpResult = '';
                            for (var i = 0; i < item['photos'][0].length; i++) {
                                tmpResult = tmpResult + '<img src="' + 'http://10.111.4.5:8080' + item['photos'][0][i] + '" style="width:100px; height: 100px;">';
                            }
                            item['photos'] = tmpResult;
                        }
                    })
                }).catch(function (error) {
                    console.log(error);
                })
            },
            logout() {
                axios.post('http://10.111.4.5:8080/ChangeOnlineStatus/changeOnlineStatus', {
                    token: localStorage.getItem("userName")
                });
                localStorage.removeItem('userName');
                localStorage.removeItem('rating');
                bus.$emit('stopRenderApp', true);
                bus.$emit('showMessageEmailConfirmNeed', false);
                $('html').removeClass('active shadowed');
                $('#overlay').remove();
                bus.$emit("fillProfile", false);
                bus.$emit("showResult", false);
            },
            blockUser(item) {
                axios.post('http://10.111.4.5:8080/BlockUsers/BlockUser', {
                    login: localStorage.getItem("userName"),
                    blockUser: $('#block_user').val()
                }).then((response) => {
                }).catch(function (error) {
                    console.log(error);
                });
                let decodedName = JSON.parse(decode(localStorage.getItem("userName")));
                const socket = io('http://10.111.4.5:8083');
                const body = [$('#block_user').val()];
                socket.emit('block action', body);
                item.block = true;
                document.getElementById(item.newid).style.display = "none";
            }
        },
        mounted() {
            let self = this;
            let trigger = 0;

            window.onresize = function (e) {
                if (self.chat && !trigger && window.innerWidth > 1100) {
                    trigger = 1;
                    self.chat = false;
                    setTimeout(function () {
                        self.chat = true
                    }, 0.005)
                }
                if (self.chat && trigger && window.innerWidth < 1100) {
                    trigger = 0;
                    self.chat = false;
                    setTimeout(function () {
                        self.chat = true
                    }, 0.005)
                }
            }
            const socket = io('http://10.111.4.5:8083');
            socket.on('block action', (msg) => {
                let decodedName = JSON.parse(decode(localStorage.getItem("userName")));
                let myName = msg[0];
                if (myName === decodedName.name) {
                    if (self.chat) {
                        self.chat = false;
                        setTimeout(function () {
                            self.chat = true
                        }, 0.005)
                    }
                }
            });

            //Read now chat with me or not
            socket.on('reading chat', (msg) => {
                let decodedName = JSON.parse(decode(localStorage.getItem("userName")));
                let hisName = JSON.parse(decode(msg[0]));
                let myName = msg[1];
                if (myName === decodedName.name) {
                    if (!this.chat) {
                        axios.post('http://10.111.4.5:8080/Token/addMessagesCounter', {
                            login: localStorage.getItem("userName"),
                            hisLogin: hisName.name
                        }).then((response) => {
                            if (response.data > 0) {
                                this.showMessages = true;
                                this.messages = response.data;

                            }
                        }).catch(function (error) {
                            console.log(error)
                        });
                        this.$toast.success({
                            title: hisName.name,
                            message: 'You have a new message'
                        })
                    }
                    else if ($('#userLogin').val() !== hisName.name) {
                        this.$toast.success({
                            title: 'New message',
                            message: 'You have a new message from ' + hisName.name
                        })
                        axios.post('http://10.111.4.5:8080/Token/addMessagesPersonalCounter', {
                            login: localStorage.getItem("userName"),
                            hisLogin: hisName.name
                        }).then((response) => {
                            if ($('#userLogin').val() !== hisName.name) {
                                document.getElementById(hisName.name).childNodes[2].style.display = "flex";
                                document.getElementById(hisName.name).childNodes[2].firstChild.innerText = response.data
                            }
                        }).catch(function (error) {
                            console.log(error)
                        })
                    }
                }
            });

            socket.on('like action', (msg) => {
                    let name = JSON.parse(decode(localStorage.getItem("userName")));
                    if (name.name === msg.name) {
                        self.notifications = Number(msg.notifications);
                        if (self.toggleCard) {
                            $('#notificationMessages').prepend($('<li></li><br>').text(msg.message));
                            self.showNotifications = false;
                            self.resetNotifications();
                        }
                        else if (self.toggleCardMobile) {
                            $('#notificationMessagesMobile').prepend($('<li>').text(msg.message));
                            self.showNotifications = false;
                            self.resetNotifications();
                        }
                        else {
                            if (msg.myName) {
                                this.$toast.success({
                                    title: msg.myName + ' likes you',
                                    message: 'It`s his best choice :)'
                                })
                            }
                            if (msg.likeUser) {
                                this.$toast.success({
                                    title: msg.likeUser + ' likes you',
                                    message: 'It`s his best choice :)'
                                })
                            }
                            self.showNotifications = true;
                        }
                        if (self.chat) {
                            self.chat = false
                            setTimeout(function () {
                                self.chat = true
                            }, 0.005)
                        }
                    }
                    if (name.name === msg.myName) {
                        self.notifications = Number(msg.myNotifications);
                        if (self.toggleCard) {
                            $('#notificationMessages').prepend($('<li></li><br>').text(msg.message));
                            self.showNotifications = false;
                            self.resetNotifications();
                        }
                        else if (self.toggleCardMobile) {
                            $('#notificationMessagesMobile').prepend($('<li>').text(msg.message));
                            self.showNotifications = false;
                            self.resetNotifications();
                        }
                        else {
                            self.showNotifications = true;
                        }
                        if (self.chat) {
                            self.chat = false
                            setTimeout(function () {
                                self.chat = true
                            }, 0.005)
                        }
                    }
                }
            );
            socket.on('view profile action', (msg) => {
                let name = JSON.parse(decode(localStorage.getItem("userName")));
                if (name.name === msg.name) {
                    self.notifications = Number(msg.notifications) + 1;
                    if (self.toggleCard) {
                        $('#notificationMessages').prepend($('<li></li><br>').text(msg.message));
                        self.showNotifications = false;
                        self.resetNotifications();
                    }
                    else if (self.toggleCardMobile) {
                        $('#notificationMessagesMobile').prepend($('<li></li><br>').text(msg.message));
                        self.showNotifications = false;
                        self.resetNotifications();
                    }
                    else {
                        self.showNotifications = true;
                    }
                }
            });
            socket.on('dislike action', (msg) => {
                let name = JSON.parse(decode(localStorage.getItem("userName")));
                if (name.name === msg.name) {
                    self.notifications = Number(msg.notifications) + 1;
                    if (self.toggleCard) {
                        $('#notificationMessages').prepend($('<li></li><br>').text(msg.message));
                        self.showNotifications = false;
                        self.resetNotifications();
                    }
                    else if (self.toggleCardMobile) {
                        $('#notificationMessagesMobile').prepend($('<li></li><br>').text(msg.message));
                        self.showNotifications = false;
                        self.resetNotifications();
                    }
                    else {
                        self.showNotifications = true;
                    }
                    if (self.chat) {
                        self.chat = false
                        setTimeout(function () {
                            self.chat = true
                        }, 0.005)
                    }
                }
            });

            axios.post('http://10.111.4.5:8080/GetMatches/getMatches', {
                login: localStorage.getItem("userName")
            }).then((response) => {
                if (response.data === "empty") {
                    this.seen = false
                    return;
                }
                this.userCards = response.data;
                this.userCards.forEach(function (item, i, arr) {
                    if (item['photos'].length) {
                        let tmpResult = '';
                        for (var i = 0; i < item['photos'][0].length; i++) {
                            tmpResult = tmpResult + '<img src="' + 'http://10.111.4.5:8080' + item['photos'][0][i] + '" style="width:100px; height: 100px;">';
                        }
                        item['photos'] = tmpResult;
                    }
                })
            }).catch(function (error) {
                console.log(error);
            });
            axios.post('http://10.111.4.5:8080/CountMessagesNotifications/countMessagesNotifications', {
                login: localStorage.getItem("userName")
            }).then((response) => {
                let msg = response.data.split(',');
                response.data.split(',');
                this.messages = msg[0];
                this.notifications = msg[1];
                if (this.messages > 0) {
                    this.showMessages = true;
                }
                else {
                    this.showMessages = false;
                }
                if (this.notifications > 0) {
                    this.showNotifications = true;

                }
                else {
                    this.showNotifications = false;
                }
            }).catch(function (error) {
                console.log(error);
            });
        }
    }
</script>

<style>

    .about-me {
        line-height: 1;
        margin-top: 30px;
    }

    .about-me-p {
        line-height: 0.9;
    }

    .md-menu {
        margin-right: -15px;
    }

    .dislike {
        width: 25px !important;
        height: 25px !important;
    }

    #notificationMessagesMobile {
        text-align: center;
        list-style-type: none;
        margin: 0;
        padding: 0;
    }

    #notificationMessages {
        text-align: center;
        list-style-type: none;
        margin: 0;
        padding: 0;
    }

    #notificationMessages li {
        cursor: pointer;
        border-bottom: .2px solid grey;
        width: 100%;
        font: bold italic 110% serif;
        padding: 5px 10px;
    }

    #notificationMessagesMobile li {
        cursor: pointer;
        border-bottom: .2px solid grey;
        width: 100%;
        font: bold italic 110% serif;
        padding: 5px 10px;
    }

    #notificationMessages li:nth-child(odd) {
        cursor: pointer;
        border-bottom: .2px solid grey;
        width: 100%;
        font: bold italic 110% serif;
        background: #eee;
    }

    #notificationMessagesMobile li:nth-child(odd) {
        cursor: pointer;
        border-bottom: .2px solid grey;
        width: 100%;
        font: bold italic 110% serif;
        background: #eee;
    }

    #notificationMessages li:hover {
        background: #A9A9A9;
    }

    #notificationMessagesMobile li:hover {
        background: #A9A9A9;
    }

    .author-card {
        padding: 8px 16px;
        display: flex;
        align-items: center;
    }

    .author-card .md-avatar {
        margin-right: 16px;
    }

    .author-card .author-card-info {
        display: flex;
        flex-flow: column;
        flex: 1;
    }

    .author-card span {
        font-size: 16px;
    }

    .author-card .author-card-links {
        display: flex;
    }

    .author-card .author-card-links a + a {
        margin-left: 8px;
    }

    .button-position {
        margin-left: 13px !important;
        margin-top: 22px !important;
        margin-bottom: -15px !important;
    }

    .notifications {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 20px;
        height: 20px;
        background: red;
        border-radius: 50%;
        margin-left: 35px;
        margin-top: -5px;
        position: absolute;
    }

    .notification-counter-span {
        position: absolute;
        z-index: 7;
        color: white;
        font-size: 10px;
    }

    .notifications-mobile {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 15px;
        height: 15px;
        background: red;
        border-radius: 50%;
        margin-left: 10px;
        margin-top: -10px;
        position: absolute;
    }

    #hash_tags {
        border: 4px double black;
        margin-top: 20px !important;
        width: 200px !important;
        height: 50px !important;
        resize: none;
    }

    .margin-button {
        margin-left: 8px !important;
    }

    .viewport {
        width: 320px;
        max-width: 100%;
        display: inline-block;
        vertical-align: top;
        overflow: auto;
        border: 1px solid rgba(0, 0, 0, 0.12);
    }

    .chips {
        display: flex;
        justify-content: center;
    }

    .sort-and-filter {
        display: flex;
        flex-direction: row;
        justify-content: center;
    }

    #bottom-bar {
        display: flex;
        justify-content: space-between;
    }

    .online {
        width: 16px !important;
        height: 16px !important;
        margin-bottom: 22px;
    }

    .offline {
        margin-left: 140px;
        width: 16px !important;
        height: 16px !important;
    }

    .content-div {
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .content-img {
        width: 180px !important;
        height: 200px !important;
    }

    .md-content {
        display: flex;
        justify-content: center;
        min-height: 300px;
        overflow-x: hidden;
        overflow-y: hidden;
        line-height: 1.5;
    }

    .md-dialog {
        max-width: 768px;
    }

    html, body {
        overflow-x: hidden !important;
    }

    .md-card {
        width: 320px;
        margin: 4px;
        display: inline-block;
        vertical-align: top;
    }

    .md-card-example .md-subhead .md-icon {
        width: 16px;
        min-width: 16px;
        height: 16px;
        font-size: 16px !important;
    }

    .md-subhead {
        word-break: normal;
        word-wrap: normal;
        overflow-wrap: normal;
    }

    .md-card-example .md-subhead span {
        vertical-align: middle;
    }

    .md-card-example .card-reservation {
        margin-top: 8px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .md-card-example .card-reservation .md-icon {
        margin: 8px;
    }

    .md-card-example .md-button-group {
        display: flex;
    }

    .md-card-example .md-button-group .md-button {
        min-width: 60px;
        border-radius: 2px;
    }

    .resultDiv {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .photoClass {
        width: 320px !important;
        height: 360px !important;
    }

    .sliderDiv {
        display: flex;
        margin-bottom: 20px;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .sliderPos {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .md-progress-bar {
        margin: 24px;
    }

    .md-app {
        min-height: 100%;
    }

    .md-drawer {
        width: 230px;
        max-width: calc(100vw - 125px);
    }

    .phone-viewport {
        width: 320px;
        height: 200px;
        display: inline-flex;
        align-items: flex-end;
        overflow: hidden;
        border: 1px solid rgba(0, 0, 0, 0.26);
        background: rgba(0, 0, 0, 0.06);
    }

    @media only screen and (min-width: 600px) {
        #bottom-bar {
            display: none;
        }
    }

    @media only screen and (max-width: 600px) {
        #header {
            display: none;
        }
    }

    @media only screen and (max-width: 760px) {
        .content-div {
            width: 100%;
        }

        .sort-and-filter {
            flex-direction: column;
            margin-left: 15px;
        }

        .sliderPos {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .mobile-range {
            margin-top: 10px !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
        }

        .md-content {
            display: flex;
            justify-content: center;
            min-height: 300px;
            overflow-x: hidden;
            overflow-y: hidden;
            line-height: 1.5;
        }
    }
</style>