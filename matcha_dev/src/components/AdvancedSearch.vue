<template>
    <div>
        <div class="sort-and-filter">
            <div class="viewport">
                <md-toolbar :md-elevation="5">
                    <span class="md-title">Filter</span>
                    <span v-if="upArrowFilter" v-on:click="showHideFilter"
                          class="fas fa-sort-up span-position-up"></span>
                    <span v-if="downArrowFilter" v-on:click="showHideFilter"
                          class="fas fa-sort-down span-position-down"></span>
                </md-toolbar>
                <md-list id="showHideFilter" class="md-double-line">
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
                        <label id="preferences-label" for="preferences">Preferences</label>
                        <div id="preferences">
                            <md-radio v-model="radio" :value="false" type="radio" name="gender">Bisexual
                            </md-radio>
                            <md-radio v-model="radio" value="Heterosexual" id="heterosexual" type="radio" name="gender">
                                Heterosexual
                            </md-radio>
                            <md-radio v-model="radio" value="Homosexual" id="homosexual" type="radio" name="gender">
                                Homosexual
                            </md-radio>
                        </div>
                        <div id="check-box">
                            <md-checkbox v-model="education">Higher education</md-checkbox>
                            <md-checkbox v-model="children">Children</md-checkbox>
                        </div>
                        <div class="sliderDiv">
                            <div>Height</div>
                            <vue-slider v-model="height.value" class="mobile-range"
                                        v-bind="height"></vue-slider>
                        </div>
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
                    <span v-if="upArrowSort" v-on:click="showHideSort" class="fas fa-sort-up span-position-up"></span>
                    <span v-if="downArrowSort" v-on:click="showHideSort"
                          class="fas fa-sort-down span-position-down"></span>
                </md-toolbar>
                <md-list id="showHideSort" class="md-double-line">
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
                                                                <p class="about-me-p">I`m {{ item.birthday }} years old and my login is {{ item.login }}. I`m from {{ item.city }}.</p>
                                                                <p class="about-me-p">You can find me by interests: <span v-if="item.interests" v-for="items in item.interests">{{ items }} </span></p>
                                                                <p class="about-me-p" v-if="item.children == 0">I have no children.</p>
                                                                <p class="about-me-p" v-else>I have children.</p>
                                                                <p class="about-me-p" v-if="item.education == 0">I have no education.</p>
                                                                <p class="about-me-p" v-else>I have higher education.</p>
                                                                <p class="about-me-p">My height is {{ item.height }}.</p>
                                                                <p class="about-me-p"> My rating is {{ item.rating }}.</p>
                                                                <p class="about-me-p">Distance to you: {{ item.distance }} km</p>
                                                            </p>
                                                        </md-tab>
                                                        <md-tab md-label="Photos" style="margin-top: 40px;">
                                                            <md-content style="width:100%; height: 200px;display:flex; justify-content:center;">
                                                                <div v-if="item.photos.length" v-html="item.photos"></div>
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
</template>
<script>

    import VueSlider from 'vue-slider-component'
    import axios from 'axios'
    import decode from 'jwt-decode'

    export default {
        name: 'AdvancedSearch',
        data: function () {
            return {
                filterResult: false,
                filterCards: [],
                upArrowFilter: false,
                downArrowFilter: true,
                upArrowSort: false,
                downArrowSort: true,
                education: false,
                children: false,
                radio: false,
                area: '',
                preferences: 'Bisexual',
                sortList: [
                    {message: 'Distance', id: 'distance'},
                    {message: 'Age', id: 'age'},
                    {message: 'Rating', id: 'rating'}
                ],
                height: {
                    value: [150, 150],
                    width: "200px",
                    height: 8,
                    dotSize: 20,
                    min: 150,
                    max: 220,
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
                ageOptions: {
                    value: [18, 18],
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
                    value: [1, 1],
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
                    value: [60, 60],
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
            VueSlider
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

                }).catch(function(error) {
                    console.log(error)
                })
            },
            viewProfileAction(personName) {
                const socket = io('http://10.111.4.5:8083');
                const body = [localStorage.getItem("userName"), personName];
                socket.emit('view profile action', body);
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
            showHideFilter() {
                $('#showHideFilter').slideToggle();
                this.upArrowFilter = !this.upArrowFilter;
                this.downArrowFilter = !this.downArrowFilter;
            },
            showHideSort() {
                $('#showHideSort').slideToggle();
                this.upArrowSort = !this.upArrowSort;
                this.downArrowSort = !this.downArrowSort;
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
                this.education = false;
                this.children = false;
                this.radio = false;
                this.height.value = [150, 150];
            }
            ,
            filter(geolocation, age, rating) {
                axios.post('http://10.111.4.5:8080/FilterAllMatches/filterAllMatches', {
                    login: localStorage.getItem("userName"),
                    distance: geolocation,
                    age: age,
                    rating: rating,
                    tags: this.sendTags,
                    children: this.children,
                    preferences: this.radio,
                    height: this.height.value,
                    education: this.education
                }).then((response) => {
                    this.seen = false;
                    if (response.data === "empty") {
                        this.filterResult = false;
                    } else {
                        this.filterResult = true;
                    }
                    if (response.data === "empty") {
                        this.filterResult = false;
                        return;
                    } else {
                        this.filterResult = true;
                    }
                    this.filterCards = response.data;
                    this.filterCards.forEach(function(item, i, arr) {
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
            const socket = io('http://10.111.4.5:8083');
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
                            self.showNotifications = true;
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
                    }
                }
            );
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
            })
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

<style scoped>
    .viewport {
        width: 100%;
        max-width: 100%;
        display: inline-block;
        vertical-align: top;
        overflow: auto;
        border: 1px solid rgba(0, 0, 0, 0.12);
    }

    .span-position-up {
        cursor: pointer;
        margin-top: 10px;
        margin-left: 220px;
    }

    .span-position-down {
        cursor: pointer;
        margin-left: 220px;
    }

    #preferences {
        margin-top: 10px;
        width: 200px;
        height: 110px !important;
        display: flex;
        justify-content: flex-start;
        flex-direction: column;
        border: 1px solid grey;
    }

    #preferences .md-radio {
        margin-bottom: -10px;
        margin-left: 5px;
    }

    #preferences-label {
        margin-top: 10px;
        margin-bottom: -10px;
    }

    #check-box {
        margin-top: 10px;
        margin-bottom: 30px;
        width: 200px;
        height: 80px !important;
        display: flex;
        justify-content: flex-start;
        flex-direction: column;
        border: 1px solid grey;
    }

    #check-box .md-checkbox {
        margin-bottom: -10px;
        margin-left: 5px;
    }

    .sliderDiv {
        display: flex;
        margin-bottom: 20px;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        width: 200px;
    }

    .sliderDivP {
        margin-left: -140px;
    }

    .sliderDivValue {
        color: grey;
        margin-top: -12px;
        margin-left: -160px;
        margin-bottom: 5px;
    }
</style>