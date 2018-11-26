<template>
    <div v-cloak>
        <Header/>
        <SideMenu/>
        <MainSection>
            <SignInForm/>
        </MainSection>
    </div>
</template>

<script>
    import SideMenu from './components/SideMenu.vue'
    import MainSection from './components/MainSection.vue'
    import SignInForm from './components/SignIn.vue'
    import Header from './components/Header.vue'
    import {bus} from './js/bus.js'


    export default {
        name: 'App',
        components: {
            SideMenu,
            MainSection,
            SignInForm,
            Header
        },
        mounted() {
            setTimeout(function () {
                $(function () {
                    $('html').removeClass('active shadowed');
                    var w = $(window).width(),
                        h = $(window).height();
                    $('section').width(w).height(h);
                    $('menu .container').height(h - 60);
                    $('body').prepend('<div id="overlay"></div>');

                    $('#menu').click(function () {
                        $('html').addClass('active');
                    });
                    $('#click-me').click(function () {
                        $('html').addClass('shadowed');

                    });
                    $('#close-menu').click(function () {
                        $('html').removeClass('active');
                    });
                    $('#overlay').click(function () {
                        $('html').removeClass('active shadowed');
                        bus.$emit("changeSeen", false)
                    });
                    $(window).resize(function () {
                        var w = $(window).width(),
                            h = $(window).height();
                        $('section').width(w).height(h);
                        $('menu .container').height(h - 60);
                    });

                });
            }, 200)
        }
    }
</script>

<style src="./css/header.css"></style>

