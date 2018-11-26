<template>
    <div>
        <div class="loader__message">
            Check your email, please!
        </div>
        <div class="foreground"></div>
        <div class="midground">
            <div class="tuna"></div>
        </div>

        <div class="background"></div>
    </div>
</template>

<script>
    import {bus} from '../js/bus.js'

    export default {
        created() {
            $('html').removeClass('active shadowed');
            bus.$emit('stopRenderApp', false)
            setTimeout(() => {
                bus.$emit('stopRenderApp', true)
                bus.$emit('showMessageEmailConfirmNeed', false)
                $('#overlay').remove();
                this.$router.push({path: '/'})
            }, 4000);
        }
    }
</script>

<style scoped>
    html,body {
        overflow-x: hidden !important;
        overflow-y: hidden !important;
        width: 100%;
        height: 100%;
        min-width: 320px;
        min-height: 568px;
    }
    .loader__message {
        position: absolute;
        z-index: 15;
        top: 20%;
        left: 0;
        right: 0;
        font-size: 1.5em;
        text-align: center;
        transform: translatey(1rem);
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
        overflow-x: hidden !important;
        overflow-y: hidden !important;
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