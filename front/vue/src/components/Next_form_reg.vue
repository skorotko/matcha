<template>
  <div class="form_wrapper">
    <div class="form_container">
      <div class="title_container">
        <h2>User Profile</h2>
      </div>
      <div class="row clearfix">
        <div class="">
          <form method="post" action="http://localhost:8080/UserProfile/fillingInUserProfile" id='register-form' autocomplete="off">
            <div class="row clearfix">
              <div class="foto">
                <label v-if="show" for="file">
                  <input type="file" v-on:change="handleFileSelect" style="display: none" id="file" accept="image/png">
                  <img class="icon_foto_big" id="big" src="../img/icon_foto.png">
                </label>
                <canvas v-show="!show" id="canvas"></canvas>
                <input type="hidden" name="photo" id="photo" value="">
              </div>
              <div class="col_half">
                <div class="input_field">
                  <input v-model="first_name" v-on:blur="postFirstName" type="text" name="first_name" placeholder="First Name" required/>
                <p style="color: red" v-if="show_2">{{answer}}</p>
                </div>
              </div>
              <div class="col_half">
                <div class="input_field">
                  <input v-model="second_name" v-on:blur="postSecondName" type="text" name="last_name" placeholder="Last Name" required/>
                  <p style="color: red" v-if="show_3">{{answer}}</p>
                </div>
              </div>
            </div>
            <div class="input_field radio_option">
              <div class='radio_group'>
                <input type="radio" name="gender" value="male" checked> Male
                <input type="radio" name="gender" value="female"> Female
              </div>
            </div>
            <div id="select" class="input_field radio_option">
              <select name="sexual_pref" required class="choose_sexual_pref">
                <option selected>Bisexual</option>
                <option>Heterosexual</option>
                <option>Homosexual</option>
              </select>
            </div>
            <div class="input_field radio_option">
              <textarea placeholder="Biography" name="biography"></textarea>
            </div>
            <div class="input_field radio_option">
              <!--<textarea v-model="array" v-on:keyup="postHobby" placeholder="What is your interests?" name="hobby"></textarea>-->
              <textarea placeholder="What is your interests?" name="hobby"></textarea>
            </div>
            <input id='submit-data' class="button" type="submit" value="Register"/>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'nfr',
  data: function () {
    return {
      show: true,
      show_2: false,
      show_3: false,
      array: [],
      answer: [],
      first_name: [],
      second_name: []
    }
  },
  methods: {
    handleFileSelect: function (evt) {
      this.show = !this.show
      var can = document.getElementById('canvas')
      var ctx = can.getContext('2d')
      var file = evt.target.files
      var f = file[0]
      var reader = new FileReader()
      reader.onload = (function (theFile) {
        return function (e) {
          var span = document.createElement('div')
          span.id = 'del'
          span.innerHTML = ['<img class="thumb" title="', decodeURI(theFile.name), '" src="', e.target.result, '" />'].join('')
          var img = new Image()
          img.src = e.target.result
          img.onload = function () {
            can.setAttribute('height', '130')
            can.setAttribute('width', '130')
            ctx.drawImage(img, 0, 0, 130, 130)
          }
          var photosrc = document.getElementById('photo')
          photosrc.value = e.target.result
        }
      })(f)
      if (f && f.type.match('image.*')) {
        reader.readAsDataURL(f)
      }
    },
    postHobby () {
      axios.post('http://localhost:8080/UserProfile/fillingInUserProfile', {
        hobby: this.array
      })
        .then(response => {
          this.answer = response.data
          console.log(this.answer)
        })
        .catch(errors => {
          console.log(errors)
        })
    },
    postFirstName () {
      axios.post('http://localhost:8080/UserProfile/ajaxCheck', {
        first_name: this.first_name
      })
        .then(response => {
          this.answer = response.data
          console.log(this.answer)
        })
        .catch(errors => {
          console.log(errors)
        })
      if (this.answer) {
        this.show_2 = !this.show_2
      }
    },
    postSecondName () {
      axios.post('http://localhost:8080/UserProfile/ajaxCheck', {
        second_name: this.second_name
      })
        .then(response => {
          this.answer = response.data
          console.log(this.answer)
        })
        .catch(errors => {
          console.log(errors)
        })
      if (this.answer) {
        this.show_3 = !this.show_3
      }
    }
  }
}
</script>

<style rel="stylesheet" src="../css/next_form_reg.css"></style>
