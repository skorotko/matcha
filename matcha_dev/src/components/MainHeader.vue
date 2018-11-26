<template>
    <header>
        <div class="container">
            <div style="margin-left:5px !important" id="home">
                <img id="people-in-love" src="../images/peopleinlove.png">
            </div>
            <p style="text-align:center;line-height: 0.2; margin-left: -132px">Contact us: </p>
            <p style="text-align:center;line-height: 0.2; font-style: italic">email: vsarapin@student.unit.ua</p>
            <p style="text-align:center;line-height: 0.2; font-style: italic">email: skorotko@student.unit.ua</p>
        </div>
    </header>
</template>
<script>

    import axios from 'axios'
    import {bus} from '../js/bus.js'

    export default {
        name: 'Header',
        data: function () {
            return {
                signIn: ''
            }
        },
        created() {
            this.signIn = 'Logout'
        },
        methods: {
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
                bus.$emit("fillProfile", false)
                bus.$emit("showResult", false)
            }
        }
    }
</script>

<style src="../css/header-vue.css"></style>
