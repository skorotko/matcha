<template>
    <header>
        <div class="container">
            <div style="margin-left: 5px !important" id="home">
                <img id="people-in-love" src="../images/peopleinlove.png">
            </div>
            <div class="box">
                <ul>
                    <li id="click-me" class="snip" v-on:click="change">Sign in</li>
                </ul>
            </div>
            <span id="menu"><img id="menu-icon" src="../images/menu.png"></span>
        </div>
    </header>

</template>
<script>

    import axios from 'axios'
    import {bus} from '../js/bus.js'

    export default {
        name: 'Header',
        methods: {
            change: function () {
                bus.$emit("changeSeen", true)
            }
        }
    }
</script>

<style src="../css/header-vue.css"></style>
