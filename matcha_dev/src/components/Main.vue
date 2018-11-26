<template>
    <div v-cloak>
        <router-view></router-view>
        <App v-if="seen" v-cloak></App>
        <NeedConfirmation v-if="needConfirmByEmail"></NeedConfirmation>
        <FillProfile v-if="fillProfile">
            <MainHeader/>
        </FillProfile>
        <Result v-if="resultView">
            <MainHeader/>
        </Result>
    </div>
</template>

<script>
    import Cabinet from './PersonalCabinet.vue'
    import App from '../App.vue'
    import NeedConfirmation from './NeedConfirmation.vue'
    import FillProfile from './FillProfile.vue'
    import Header from './Header.vue'
    import MainHeader from './MainHeader.vue'
    import Result from './ShowResult.vue'
    import {bus} from '../js/bus.js'
    import axios from 'axios'

    export default {
        name: 'Main',
        components: {
            App,
            NeedConfirmation,
            FillProfile,
            Header,
            MainHeader,
            Result,
            Cabinet
        },
        data: function () {
            return {
                seen: true,
                needConfirmByEmail: false,
                fillProfile: false,
                resultView: false
            }
        },
        created() {
            bus.$on("stopRenderApp", (data) => {
                this.seen = data
            });
            bus.$on("showMessageEmailConfirmNeed", (data) => {
                this.needConfirmByEmail = data
            });
            bus.$on("fillProfile", (data) => {
                this.fillProfile = data
            });
            bus.$on("showResult", (data) => {
                this.resultView = data
            });
        }
    }
</script>

<style></style>