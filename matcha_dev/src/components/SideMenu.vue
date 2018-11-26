<template>
    <menu>
        <div class="logo"><a href=""><img id="people-in-love1" src="../images/peopleinlove.png"></a></div>
        <span id="close-menu"><img id="close-icon" src="../images/close-icon.png"></span>
        <div class="container">
            <div class="box">
                <ul>
                                <p style="text-align:center;line-height: 0.2; margin-left: -132px">Contact us: </p>
            <p style="text-align:center;line-height: 0.2; font-style: italic">email: vsarapin@student.unit.ua</p>
            <p style="text-align:center;line-height: 0.2; font-style: italic">email: skorotko@student.unit.ua</p>
                </ul>
                <ul>
                    <li><a v-on:click="change" href="#">Sign in</a></li>
                </ul>
            </div>
        </div>
    </menu>
</template>

<script>

    import {bus} from '../js/bus.js'

export default ({
    name: 'SideMenu',
    methods: {
        change: function() {
            bus.$emit("changeSeen", !this.seen)
            $('html').removeClass('active').addClass('shadowed')
        }
    }
})
</script>

<style scoped>
#people-in-love1 {
    width: 30px;
    margin-top: -7px;
}
#close-icon {
    width: 30px;
    margin-top: -5px;
    margin-left: 0px;
}
</style>
