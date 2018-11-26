<template>
  <div class="form_wrapper">
    <div class="form_container">
      <div class="title_container">
        <h2>User Cabinet</h2>
      </div>
      <div class="row clearfix">
        <div>
            <div class="row clearfix">
              <div class="foto">
                <label v-on:mouseout="images_delete('photo_avatar')" v-on:mouseover="images_add('photo_avatar')">
                  <input type="file" v-on:click="direct_id('photo_avatar')" v-on:change="handleFileSelect" style="display: none" id="photo_avatar_input" accept="image/png, image/jpg">
                  <md-avatar class="avatar">
                    <img src="http://10.111.4.5:8080/public/web_images/add_@.png" id="photo_avatar" alt="Avatar">
                  </md-avatar>
                </label>
              </div>
              <div style="display: flex; flex-direction: row; justify-content: space-between; margin-bottom: 30px">
                <div style="display: flex; flex-direction: column">
                <label v-on:mouseout="images_delete('add_photo_1')" v-on:mouseover="images_add('add_photo_1')">
                  <input type="file" v-on:mouseover="images_add('add_photo_1')" v-on:click="direct_id('add_photo_1')" v-on:change="handleFileSelect" style="display: none" id="add_photo_1_input" accept="image/png, image/jpg">
                  <md-avatar class="photo_user">
                    <img src="http://10.111.4.5:8080/public/web_images/add_@.png" id="add_photo_1" alt="Avatar">
                  </md-avatar>
                </label>
                <div v-show="view_delete_1" v-on:click="delete_photo('add_photo_1')" class="button_delete">
                  &times
                </div>
                </div>
                <div>
                <label v-on:mouseout="images_delete('add_photo_2')" v-on:mouseover="images_add('add_photo_2')">
                  <input type="file" v-on:click="direct_id('add_photo_2')" v-on:change="handleFileSelect" style="display: none" id="add_photo_2_input" accept="image/png, image/jpg">
                  <md-avatar class="photo_user">
                    <img src="http://10.111.4.5:8080/public/web_images/add_@.png" id="add_photo_2" alt="Avatar">
                  </md-avatar>
                </label>
                <div v-show="view_delete_2" v-on:click="delete_photo('add_photo_2')" class="button_delete">
                  &times
                </div>
                </div>
                <div>
                <label v-on:mouseout="images_delete('add_photo_3')" v-on:mouseover="images_add('add_photo_3')">
                  <input type="file" v-on:click="direct_id('add_photo_3')" v-on:change="handleFileSelect" style="display: none" id="add_photo_3_input" accept="image/png, image/jpg">
                  <md-avatar class="photo_user">
                    <img src="http://10.111.4.5:8080/public/web_images/add_@.png" id="add_photo_3" alt="Avatar">
                  </md-avatar>
                </label>
                  <div v-show="view_delete_3" v-on:click="delete_photo('add_photo_3')" class="button_delete">
                    &times
                  </div>
                </div>
                <div>
                <label v-on:mouseout="images_delete('add_photo_4')" v-on:mouseover="images_add('add_photo_4')">
                  <input type="file" v-on:click="direct_id('add_photo_4')" v-on:change="handleFileSelect" style="display: none" id="add_photo_4_input" accept="image/png, image/jpg">
                  <md-avatar class="photo_user">
                    <img src="http://10.111.4.5:8080/public/web_images/add_@.png" id="add_photo_4" alt="Avatar">
                  </md-avatar>
                </label>
                  <div v-show="view_delete_4" v-on:click="delete_photo('add_photo_4')" class="button_delete">
                    &times
                  </div>
                </div>
                <div>
                <label v-on:mouseout="images_delete('add_photo_5')" v-on:mouseover="images_add('add_photo_5')">
                  <input type="file" v-on:click="direct_id('add_photo_5')" v-on:change="handleFileSelect" style="display: none" id="add_photo_5_input" accept="image/png, image/jpg">
                  <md-avatar class="photo_user">
                    <img src="http://10.111.4.5:8080/public/web_images/add_@.png" id="add_photo_5" alt="Avatar">
                  </md-avatar>
                </label>
                  <div v-show="view_delete_5" v-on:click="delete_photo('add_photo_5')" class="button_delete">
                    &times
                  </div>
                </div>
              </div>
              <div class="col_half">
                  <md-field>
                    <label>First name</label>
                    <md-input v-on:blur="postFirstName" maxlength="255" v-model="first_name"></md-input>
                  </md-field>
                <p id="check-firstName" v-html="firstNameAJAX"></p>
              </div>
              <div class="col_half">
                  <md-field>
                    <label>Last name</label>
                    <md-input v-on:blur="postLastName" maxlength="255" v-model="last_name"></md-input>
                  </md-field>
                <p id="check-lastName" v-html="lastNameAJAX"></p>
              </div>
              <div class="col_half">
                  <md-field>
                    <label>Pass</label>
                    <md-input v-on:blur="checkPasswords" type="password" v-model="pass"></md-input>
                  </md-field>
                <p id="check-password" v-html="passwordAJAX"></p>
              </div>
              <div class="col_half">
                  <md-field>
                    <label>Pass_rep</label>
                    <md-input v-on:blur="checkPasswords" type="password" v-model="pass_rep"></md-input>
                  </md-field>
                <p id="check-password_rep" v-html="passwordAJAX"></p>
              </div>
              <div class="col_half_2">
                  <md-field>
                    <label>Login</label>
                    <md-input v-on:blur="checkExistsLogin" v-model="login"></md-input>
                  </md-field>
                  <p id="check-login">{{ loginAJAX }}</p>
              </div>
              <div class="col_half_2">
                  <md-field>
                    <label>Email</label>
                    <md-input v-on:blur="checkExistsMail" v-model="mail"></md-input>
                  </md-field>
                  <p id="check-mail">{{ mailAJAX }}</p>
              </div>
              <div>
                <div>
                  <md-datepicker v-model="selectedDate" md-immediately />
                </div>
              </div>
              <div style="display:flex; align-content: space-between; padding-left: 15px">
                <div><md-radio v-model="radio" :value="false" id="male" type="radio" name="gender">Male</md-radio></div>
                <div><md-radio v-model="radio" id="female" type="radio" name="gender">Female</md-radio></div>
                <input type="hidden" name="gender" :value="radio">
              </div>
              <div>
                <md-field class="preferens_style">
                  <label :for="preferens">Sexyal preferens</label>
                  <md-select v-model="preferens">
                    <md-option value="Bisexual">Bisexual</md-option>
                    <md-option value="Heterosexual">Heterosexual</md-option>
                    <md-option value="Homosexual">Homosexual</md-option>
                  </md-select>
                </md-field>
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
            <div>
              <div>
                <gmap-map
                  v-bind:center="center"
                  v-bind:zoom="5"
                  v-bind:map-type-id="mapTypeId"
                  v-on:click="marker_add"
                  style="height: 150px; margin-bottom: 20px">
                  <gmap-marker
                    v-for="(item, index) in markers"
                    v-bind:key="index"
                    v-bind:position="item.position"
                    v-bind:src="item.src"
                    v-on:click="center=item.position"/>
                </gmap-map>
              </div>
              <div>
                <md-field>
                  <label>Biography</label>
                  <md-textarea v-model="biography" maxlength="255" md-counter="255"></md-textarea>
                </md-field>
              </div>
              <div>
                <md-field>
                  <label>Hobby</label>
                  <md-textarea v-model="hobby" maxlength="255" md-counter="255"></md-textarea>
                </md-field>
              </div>
            </div>
            <md-table>
        <md-table-row>
           <md-table-head>Last seen users:</md-table-head>
         </md-table-row>
       <md-table-row v-if="showLastSeenUsers" v-for="item in lastSeenUsers">
         <md-table-cell>{{ item }}</md-table-cell>
         </md-table-row>
        <md-table-row v-if="dontShowLastSeenUsers">
         <md-table-cell>No users yet</md-table-cell>
         </md-table-row>
        </md-table>
            <input id='submit-data' class="button" type="submit" v-on:click="sendAllInputAJAX" value="Update"/>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import VueSlider from 'vue-slider-component'
import decode from 'jwt-decode'

export default {
  name: 'nfr',
  data: function () {
    return {
      showLastSeenUsers: true,
      dontShowLastSeenUsers: false,
      lastSeenUsers: {},
      center: { lat: 50.4333, lng: 30.5167 },
      mapTypeId: "terrain",
      markers:
      [
        { position: { lat: 0, lng: 0 },
            icon: {
                url: {src: 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png'},
                size: {width: 46, height: 46, f: 'px', b: 'px'},
                scaledSize: {width: 23, height: 23, f: 'px', b: 'px'}
            }
        }
      ],
        children: false,
        attitudes: false,
        education: false,
      preferens: null,
      radio: false,
      show: true,
      answer: '',
      first_name: '',
      last_name: '',
      answer_all_input: [],
      login: '',
      mail: '',
      biography: '',
      tmpHobby: '',
      hobby: '',
      selectedDate: '',
      pass: '',
      pass_rep: '',
      loginAJAX: '',
      mailAJAX: '',
      passwordAJAX: '',
      firstNameAJAX: '',
      lastNameAJAX: '',
      disabled: true,
      disabledLogin: false,
      disabledEmail: false,
      disabledPasswords: false,
      photo: '',
      photo_id: '',
      view_delete_1: false,
      view_delete_2: false,
      view_delete_3: false,
      view_delete_4: false,
      view_delete_5: false,
      map: '',
      lat_user: '',
      lng_user: '',
      location: [],
        height: {
            width: "100%",
            show: true,
            value: 150,
            min: 150,
            max: 220,
            piecewiseLabel: false,
            tooltip: false
        }
    }
  },
    components: {
      VueSlider
    },
  methods: {
    hash (hobbies) {
      if (hobbies !== '') {
        this.tmpHobby = hobbies;
        const parseHashtags = require('parse-hashtags');
        this.hobby = parseHashtags(hobbies);
      }
    },
    marker_add: function (evt) {
      var e = JSON.stringify(evt.latLng)
      var pos = e.split(',')
      this.lat_user = pos[0].substr(7, pos[0].length)
      this.lng_user = pos[1].substr(6, pos[1].length - 7)
      this.markers[0].position.lat = Number(this.lat_user);
      this.markers[0].position.lng = Number(this.lng_user);
      this.location[0] = this.lat_user
      this.location[1] = this.lng_user
    },

    delete_photo (id) {
      var photosrc = document.getElementById(id)
      this.photo = photosrc.src
      photosrc.src = 'http://10.111.4.5:8080/public/web_images/add_@.png'
      if (id === 'add_photo_1')
        this.view_delete_1 = !this.view_delete_1
      if (id === 'add_photo_2')
        this.view_delete_2 = !this.view_delete_2
      if (id === 'add_photo_3')
        this.view_delete_3 = !this.view_delete_3
      if (id === 'add_photo_4')
        this.view_delete_4 = !this.view_delete_4
      if (id === 'add_photo_5')
        this.view_delete_5 = !this.view_delete_5
    },
    images_add (id) {
      var photosrc = document.getElementById(id)
      this.photo = photosrc.src
      photosrc.src = 'http://10.111.4.5:8080/public/web_images/add_@.png'
    },
    images_delete (id) {
      var photosrc = document.getElementById(id)
      photosrc.src = this.photo
    },
    direct_id (id) {
      this.photo_id = id
    },
    handleFileSelect: function (evt) {
      var file = evt.target.files
      var f = file[0]
      var reader = new FileReader()
      var photoId = this.photo_id
      if (this.photo_id === 'add_photo_1' && this.view_delete_1 === false)
        this.view_delete_1 = !this.view_delete_1
      if (this.photo_id === 'add_photo_2' && this.view_delete_2 === false)
        this.view_delete_2 = !this.view_delete_2
      if (this.photo_id === 'add_photo_3' && this.view_delete_3 === false)
        this.view_delete_3 = !this.view_delete_3
      if (this.photo_id === 'add_photo_4' && this.view_delete_4 === false)
        this.view_delete_4 = !this.view_delete_4
      if (this.photo_id === 'add_photo_5' && this.view_delete_5 === false)
        this.view_delete_5 = !this.view_delete_5
      reader.onload = (function (theFile) {
        return function (e) {
          var span = document.createElement('div')
          span.id = 'del'
          span.innerHTML = ['<img class="thumb" title="', decodeURI(theFile.name), '" src="', e.target.result, '" />'].join('')
          var img = new Image()
          img.src = e.target.result
          var photosrc = document.getElementById(photoId)
          photosrc.src = e.target.result
          this.photo = photosrc.value
        }
      })(f)
      if (f && f.type.match('image.*')) {
        reader.readAsDataURL(f)
      }
    },
    postFirstName () {
      axios.post('http://10.111.4.5:8080/PersonalCabinet/checkFSName', {
        firstName: this.first_name
      })
        .then(response => {
          $('#check-firstName').css('color', 'red')
          this.firstNameAJAX = response.data
        })
        .catch(errors => {
          console.log(errors)
        })
    },
    postLastName () {
      axios.post('http://10.111.4.5:8080/PersonalCabinet/checkFSName', {
        secondName: this.last_name
      })
        .then(response => {
          $('#check-lastName').css('color', 'red')
          this.lastNameAJAX = response.data
        })
        .catch(errors => {
          console.log(errors)
        })
    },
    checkExistsLogin () {
      axios.post('http://10.111.4.5:8080/PersonalCabinet/checkLoginAJAX', {
        login: this.login
      })
        .then(response => {
          if (response.data === true) {
            this.loginAJAX = 'Ok, login is available'
            $('#border-color').css('borderColor', 'green')
            $('#check-login').css('color', 'green')
            this.disabledLogin = true
            if (this.disabledLogin === true && this.disabledEmail === true && this.disabledPasswords === true) {
              this.disabled = false
            }
          }
          else if (response.data === false) {
            this.loginAJAX = 'Such login already exists'
            $('#border-color').css('borderColor', 'red')
            $('#check-login').css('color', 'red')
            this.disabledLogin = false
          }
          else if (response.data === 'empty') {
            this.loginAJAX = 'Login can`t be empty!'
            $('#border-color').css('borderColor', 'red')
            $('#check-login').css('color', 'red')
            this.disabledLogin = false
          }
          else if (response.data === 1) {
            this.loginAJAX = 'Must be between 4 and 20 characters!'
            $('#border-color').css('borderColor', 'red')
            $('#check-login').css('color', 'red')
            this.disabledLogin = false
          }
          else if (response.data === 2) {
            this.loginAJAX = 'Should be only latin letters!'
            $('#border-color').css('borderColor', 'red')
            $('#check-login').css('color', 'red')
            this.disabledLogin = false
          }
        })
        .catch(errors => {
          console.log(errors)
        })
    },
    checkExistsMail () {
      axios.post('http://10.111.4.5:8080/PersonalCabinet/checkExistsMail', {
        mail: this.mail
      })
        .then(response => {
          if (response.data === true) {
            this.mailAJAX = 'Ok, email is available!'
            $('#border-color-too').css('borderColor', 'green')
            $('#check-mail').css('color', 'green')
            this.disabledEmail = true
            if (this.disabledLogin === true && this.disabledEmail === true && this.disabledPasswords === true) {
              this.disabled = false
            }
          }
          else if (response.data === false) {
            this.mailAJAX = 'Such email already exists!'
            $('#border-color-too').css('borderColor', 'red')
            $('#check-mail').css('color', 'red')
            this.disabledEmail = false
          }
          else if (response.data === 'empty') {
            this.mailAJAX = 'Email can`t be empty!'
            $('#border-color-too').css('borderColor', 'red')
            $('#check-mail').css('color', 'red')
            this.disabledEmail = false
          }
          else if (response.data === 1) {
            this.mailAJAX = 'Invalid email format!'
            $('#border-color-too').css('borderColor', 'red')
            $('#check-mail').css('color', 'red')
            this.disabledEmail = false
          }
        })
        .catch(errors => {
          console.log(errors)
        })
    },
    checkPasswords () {
      axios.post('http://10.111.4.5:8080/PersonalCabinet/checkPasswords', {
        pass: this.pass,
        pass_rep: this.pass_rep
      })
        .then(response => {
          if (response.data === true) {
            this.passwordAJAX = ''
            this.disabledPasswords = true
            if (this.disabledLogin === true && this.disabledEmail === true && this.disabledPasswords === true) {
              this.disabled = false
            }
          }
          else if (response.data === 2) {
            this.passwordAJAX = 'Min: 8 symbols, one lowercase, one uppercase!'
            $('#check-password').css('color', 'red')
            $('#check-password_rep').css('color', 'red')
            this.disabledPasswords = false
          }
          else if (response.data === 'emptyP') {
            this.passwordAJAX = 'Passwords do not match!'
            $('#check-password').css('color', 'red')
            $('#check-password_rep').css('color', 'red')
            this.disabledPasswords = false
          }
          else if (response.data === 'emptyR') {
            this.passwordAJAX = 'Passwords do not match!'
            $('#check-password').css('color', 'red')
            $('#check-password_rep').css('color', 'red')
            this.disabledPasswords = false
          }
          else if (response.data === 1) {
            this.passwordAJAX = 'Passwords do not match!'
            $('#check-password').css('color', 'red')
            $('#check-password_rep').css('color', 'red')
            this.disabledPasswords = false
          }
        })
        .catch(errors => {
          console.log(errors)
        })
    },
    sendAllInputAJAX () {
        if(this.firstNameAJAX !== '' || this.lastNameAJAX !== '' || this.passwordAJAX !== '' ||
            (this.loginAJAX !== '' && this.loginAJAX !== 'Ok, login is available') || (this.mailAJAX !== '' && this.mailAJAX !== 'Ok, email is available!')) {
            return;
        }
      this.hash(this.hobby);
      var photoSrcAvatar = document.getElementById('photo_avatar').src
      var photoAdd1 = document.getElementById('add_photo_1').src
      var photoAdd2 = document.getElementById('add_photo_2').src
      var photoAdd3 = document.getElementById('add_photo_3').src
      var photoAdd4 = document.getElementById('add_photo_4').src
      var photoAdd5 = document.getElementById('add_photo_5').src
      if (this.answer_all_input.photo === document.getElementById('photo_avatar').src){
        photoSrcAvatar = ''
      }
      if (photoAdd1 === 'http://10.111.4.5:8080/public/web_images/add_@.png') {
        photoAdd1 = ''
      } else if (this.answer_all_input.photo_user_1 === photoAdd1) {
        photoAdd1 = this.answer_all_input.photo_user_src_1
      }
      if (photoAdd2 === 'http://10.111.4.5:8080/public/web_images/add_@.png') {
        photoAdd2 = ''
      } else if (this.answer_all_input.photo_user_2 === photoAdd2) {
        photoAdd2 = this.answer_all_input.photo_user_src_2
      }
      if (photoAdd3 === 'http://10.111.4.5:8080/public/web_images/add_@.png') {
        photoAdd3 = ''
      } else if (this.answer_all_input.photo_user_3 === photoAdd3) {
        photoAdd3 = this.answer_all_input.photo_user_src_3
      }
      if (photoAdd4 === 'http://10.111.4.5:8080/public/web_images/add_@.png') {
        photoAdd4 = ''
      } else if (this.answer_all_input.photo_user_4 === photoAdd4) {
        photoAdd4 = this.answer_all_input.photo_user_src_4
      }
      if (photoAdd5 === 'http://10.111.4.5:8080/public/web_images/add_@.png') {
        photoAdd5 = ''
      } else if (this.answer_all_input.photo_user_5 === photoAdd5) {
        photoAdd5 = this.answer_all_input.photo_user_src_5
      }
      axios.post('http://10.111.4.5:8080/PersonalCabinet/editProfile', {
          token_login: localStorage.getItem('userName'),
        photo: photoSrcAvatar,
        photo_user_1: photoAdd1,
        photo_user_2: photoAdd2,
        photo_user_3: photoAdd3,
        photo_user_4: photoAdd4,
        photo_user_5: photoAdd5,
        first_name: this.first_name,
        last_name: this.last_name,
        login: this.login,
        email: this.mail,
        biography: this.biography,
        hobby: this.hobby,
        sexual_pref: this.preferens,
        birthday: this.selectedDate,
        password: this.pass,
        gender: this.radio,
        location: this.location,
          children: this.children,
          education: this.education,
          attitude: this.attitudes,
          height: this.height.value
      })
        .then(response => {
            localStorage.setItem('userName', response.data)
            this.$toast.success({
                title: 'Updated',
                message: 'Changes saved!'
            });
        })
        .catch(errors => {
          console.log(errors)
        })
        this.hobby  = this.tmpHobby;
    }
  },
  mounted() {
    axios.post('http://10.111.4.5:8080/LastSeenUsers/lastSeenUsers', {
      login: JSON.parse(decode(localStorage.getItem("userName")))
    }).then((response) => {
      if (response.data === "empty") {
        this.showLastSeenUsers = false;
        this.dontShowLastSeenUsers = true;
      }
      else {
       this.lastSeenUsers = response.data;
       this.showLastSeenUsers = true;
       this.dontShowLastSeenUsers = false;
      }
    }).catch(function(error) {
      console.log(error);
    })
  },
  created () {
    axios.post('http://10.111.4.5:8080/PersonalCabinet/ajaxSwitch', {
      token_login: localStorage.getItem('userName')
    })
      .then(response => {
        this.answer_all_input = response.data
        if (this.answer_all_input) {
          var photosrc = document.getElementById('photo_avatar')
          var photoAdd1 = document.getElementById('add_photo_1')
          var photoAdd2 = document.getElementById('add_photo_2')
          var photoAdd3 = document.getElementById('add_photo_3')
          var photoAdd4 = document.getElementById('add_photo_4')
          var photoAdd5 = document.getElementById('add_photo_5')
          photosrc.src = this.answer_all_input.photo

          if (this.answer_all_input.photo_user_1 === '') {
            photoAdd1.src = 'http://10.111.4.5:8080/public/web_images/add_@.png'
          } else {
            photoAdd1.src = this.answer_all_input.photo_user_1
          }

          if (this.answer_all_input.photo_user_2 === '') {
            photoAdd2.src = 'http://10.111.4.5:8080/public/web_images/add_@.png'
          } else {
            photoAdd2.src = this.answer_all_input.photo_user_2
          }
          if (this.answer_all_input.photo_user_3 === '') {
            photoAdd3.src = 'http://10.111.4.5:8080/public/web_images/add_@.png'
          } else {
            photoAdd3.src = this.answer_all_input.photo_user_3
          }

          if (this.answer_all_input.photo_user_4 === '') {
            photoAdd4.src = 'http://10.111.4.5:8080/public/web_images/add_@.png'
          } else {
            photoAdd4.src = this.answer_all_input.photo_user_4
          }

          if (this.answer_all_input.photo_user_5 === '') {
            photoAdd5.src = 'http://10.111.4.5:8080/public/web_images/add_@.png'
          } else {
            photoAdd5.src = this.answer_all_input.photo_user_5
          }
            if (document.getElementById('add_photo_1').src !== 'http://10.111.4.5:8080/public/web_images/add_@.png')
              this.view_delete_1 = !this.view_delete_1
            if (document.getElementById('add_photo_2').src !== 'http://10.111.4.5:8080/public/web_images/add_@.png')
              this.view_delete_2 = !this.view_delete_2
            if (document.getElementById('add_photo_3').src !== 'http://10.111.4.5:8080/public/web_images/add_@.png')
              this.view_delete_3 = !this.view_delete_3
            if (document.getElementById('add_photo_4').src !== 'http://10.111.4.5:8080/public/web_images/add_@.png')
              this.view_delete_4 = !this.view_delete_4
            if (document.getElementById('add_photo_5').src !== 'http://10.111.4.5:8080/public/web_images/add_@.png')
                this.view_delete_5 = !this.view_delete_5
          this.first_name = this.answer_all_input.first_name
          this.last_name = this.answer_all_input.last_name
          this.login = this.answer_all_input.login
          this.mail = this.answer_all_input.mail
          this.biography = this.answer_all_input.biography
          this.hobby = this.answer_all_input.hobby
          this.preferens = this.answer_all_input.sexual_pref
          this.selectedDate = this.answer_all_input.birthday
          this.markers[0].position.lat = Number(this.answer_all_input.lat)
          this.markers[0].position.lng = Number(this.answer_all_input.lng)
            this.height.value = this.answer_all_input.height
            if(this.answer_all_input.attitude === '' || this.answer_all_input.attitude === 'atheist') {
                this.attitudes = false
            } else {
                this.attitudes =  this.answer_all_input.attitude
            }
            if(this.answer_all_input.children === '1') {
              this.children = !this.children
            }
            if(this.answer_all_input.education === '1') {
                this.education = !this.education
            }
          if (this.answer_all_input.gender === 'Female') {
            this.radio = 'on'
          }
        }
      })
      .catch(errors => {
        console.log(errors)
      })
  }
}
</script>

<style scoped>
  
  .preferens_style {
    width: 340px;
  }

  .sliderDiv {
    display: flex;
    margin-bottom: 20px;
    flex-direction: column;
    justify-content: center;
    align-items: center;
  }

  .sliderDivP {
    margin-left: -305px;
  }

  .sliderDivValue {
    color: grey;
    margin-top: -12px;
    margin-left: -325px;
    margin-bottom: 5px;
  }

  .attitudes {
    display: flex;
    flex-direction: column;
    justify-content: center;
    border: 1px solid #cccccc;
    margin-bottom: 20px;
  }

  .attitudes .md-radio {
    margin-left: 10px;
    margin-top: -10px;

  }

  .attitudes p {
    display: flex;
    justify-content: center;
  }

  .button_delete {
    font-family: Verdana;
    font-size: 38px;
    font-weight: normal;
    color: red;
    margin-left: 17px;
    cursor: pointer;
  }

  .avatar {
    width: 170px;
    height: 170px;
    border-radius: 50%;
    border-style: solid;
    border-width: medium;
  }

  .photo_user{
    width: 65px;
    height: 65px;
    border-radius: 50%;
    border-style: solid;
    border-width:  medium;
  }

  body {
    font-family: Verdana, Geneva, sans-serif;
    font-size: 14px;
    background: #f2f2f2;
  }

  .form_wrapper {
    background: #fff;
    width: 400px;
    max-width: 100%;
    box-sizing: border-box;
    padding: 25px;
    margin: 1% auto 0;
    position: relative;
    z-index: 1;
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

  @media (max-width: 600px){
    .form_wrapper {
    background: #fff;
    width: 320px;
    max-width: 100%;
    box-sizing: border-box;
    padding: 25px;
    margin: 1% auto 0;
    position: relative;
    z-index: 1;
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
  .photo_user{
    width: 55px;
    height: 55px;
    border-radius: 50%;
    border-style: solid;
    border-width:  medium;
  }
  .preferens_style {
    width: 270px;
  }
  .sliderDivP {
    margin-left: -205px;
  }
  .sliderDivValue {
    color: grey;
    margin-top: -12px;
    margin-left: -225px;
    margin-bottom: 5px;
  }
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

  .form_wrapper .col_half_2 {
    width: 100%;
    float: left;
  }

  /*.form_wrapper .col_quarter {
    width: 25%;
    float: left;
  }*/

  .form_wrapper input[type=text], .form_wrapper input[type=email], .form_wrapper input[type=password] {
    width: 100%;
    padding: 8px 10px 9px 10px;
    height: 35px;
    box-sizing: border-box;
    outline: none;
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

  .button:hover {
    background: #e1a70a;
  }

  .button:focus {
    background: #e1a70a;
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
  .foto{
    display: flex;
    justify-content: center;
    margin-bottom: 40px;
  }

  .icon_foto_big{
    width: 130px;
    height: 130px
  }
</style>
