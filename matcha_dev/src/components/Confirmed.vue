<template>
    <div>
        <div class="loader">
            <div class="loader__decoration loader__decoration--a"></div>
            <div class="loader__decoration loader__decoration--b"></div>
            <div class="loader__decoration loader__decoration--c"></div>
            <div id="loaded" class="loader__result">
                <div class="loader__icon">
                    <i class="fa fa-fw fa-check"></i>
                </div>
                <div class="loader__message">
                    confirmed!
                </div>
            </div>
        </div>
        <div class="foreground"></div>

        <div class="midground">
            <div class="tuna"></div>
        </div>

        <div class="background"></div>
    </div>
</template>

<script>
    import axios from 'axios'
    import {bus} from '../js/bus.js'

    export default {
        created() {
            setTimeout(function () {
                if (document.getElementById('loaded'))
                    document.getElementById('loaded').classList.toggle('loader__result--is-complete');
            }, 3000);
            bus.$emit('stopRenderApp', false);
            axios.post('http://10.111.4.5:8080/activation/activation', {
                hash: this.$route.params.hash
            }).then((response) => {
                if (response.data === "success") {
                    setTimeout(() => {
                        bus.$emit('stopRenderApp', true);
                        this.$router.push({path: '/'})
                    }, 4000);
                }
                else {
                    bus.$emit('stopRenderApp', true);
                    this.$router.push({path: '/'})
                }
            }).catch(function (error) {
                console.log(error);
            });
        }
    }
</script>

<style scoped>
    @import url('https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    @import url('https://fonts.googleapis.com/css?family=Lato:300,400');

    :root {
        overflow-x: hidden;
        overflow-y: hidden;
        min-height: 100vh;
        min-width: 100vh;
    }

    .loader {
        position: fixed;
        top: 20%;
        left: 50%;
        width: 15rem;
        min-height: 15rem;
        background-color: white;
        border-radius: 50%;
        transform: translate(-50%, -50%);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.5);
        overflow: hidden;
        font: normal normal 9.33333pt Lato, sans-serif;
    }

    .loader__result {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        overflow-x: hidden;
        overflow-y: hidden;
        color: transparent;
        background-color: #37c0c9;
        transition: width 333ms ease-in, height 333ms ease-in, color 125ms ease-in, font-size 500ms cubic-bezier(0, 1.58, 0.18, 1) 125ms, border-radius 125ms ease-in;
        font-size: 0;
        text-shadow: 0 0.125em 0.25em rgba(0, 0, 0, 0.5);
        transform: translate(-50%, -50%);
    }

    .loader__result--is-complete {
        font-size: 1rem;
        width: 100vh;
        height: 100vh;
        color: white;
    }

    .loader__icon {
        position: absolute;
        top: 50%;
        left: 50%;
        font-size: 3em;
        transform: translatey(-25%) translate(-50%, -50%);
    }

    .loader__message {
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        font-size: 1.5em;
        text-align: center;
        transform: translatey(1rem);
    }

    .loader__decoration {
        position: absolute;
        top: 50%;
        left: 50%;
        border-radius: 50%;
        width: 2rem;
        height: 2rem;
    }

    .loader__decoration--a {
        background-color: rgba(60, 175, 218, 0.15);
        animation: u1kwj2sls 1s infinite ease-in-out;
        animation-delay: -0.25s;
    }

    @keyframes u1kwj2sls {
        from, to {
            transform: translate(-50%, -50%) scale(2.5);
        }
        50% {
            transform: translate(-50%, -50%) scale(1.5);
        }
    }

    .loader__decoration--b {
        background-color: rgba(60, 175, 218, 0.15);
        animation: u1kwj2slv 1s infinite ease-in-out;

        animation-delay: -0.333s;
    }

    @keyframes u1kwj2slv {
        from, to {
            transform: translate(-50%, -50%) scale(1.75);
        }
        50% {
            transform: translate(-50%, -50%) scale(1.25);
        }
    }

    .loader__decoration--c {
        background-color: #3cafda;
        animation: u1kwj2sm4 1s infinite ease-in-out;
    }

    @keyframes u1kwj2sm4 {
        from, to {
            transform: translate(-50%, -50%) scale(1);
        }
        50% {
            transform: translate(-50%, -50%) scale(0.75);
        }
    }

    .tuna {
        animation: walk-cycle 1s steps(12) infinite;
        background: url(../images/tuna_sprite.png) 0 0 no-repeat;
        height: 200px;
        width: 400px;
        position: absolute;
        bottom: 1px;
        left: 50%;
        margin-left: -200px;
        transform: translateZ(0); /* offers a bit of a performance boost by pushing some of this processing to the GPU in Safari*/
    }

    @keyframes walk-cycle {
        0% {
            background-position: 0 0;
        }
        100% {
            background-position: 0 -2391px;
        }
    }

    .foreground, .midground, .background {
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
    }

    .foreground {
        animation: parallax_fg linear 10s infinite both;
        background: url(../images/foreground_grass.png) 0 100% repeat-x;
        z-index: 3;
    }

    @keyframes parallax_fg {
        0% {
            background-position: -3584px 100%;
        }
        100% {
            background-position: 0 100%;
        }
    }

    .midground {
        animation: parallax_mg linear 20s infinite;
        background: url(../images/midground_grass.png) 0 100% repeat-x;
        z-index: 2;
    }

    @keyframes parallax_mg {
        0% {
            background-position: -3000px 100%;
        }
        100% {
            background-position: 0 100%;
        }
    }

    .background {
        background-image: url(../images/background_mountain5.png),
        url(../images/background_mountain4.png),
        url(../images/background_mountain3.png),
        url(../images/background_mountain2.png),
        url(../images/background_mountain1.png);
        background-repeat: repeat-x;
        background-position: 0 100%;
        z-index: 1;
        animation: parallax_bg linear 40s infinite;
    }

    @keyframes parallax_bg {
        100% {
            background-position-x: 2400px, 2000px, 1800px, 1600px, 1200px;
        }
    }

    body {
        background: linear-gradient(top, rgba(255, 255, 255, 1) 0%, rgba(255, 255, 255, 0) 100%),
        #d2d2d2 url(../images/background_clouds.png);
    }
</style>