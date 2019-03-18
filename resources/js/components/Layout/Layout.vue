<template>
    <div class="layout">
        <app-modals></app-modals>
        <vue-snotify></vue-snotify>
        <div class="flex w-full py-4 px-4 md:px-0">
            <brand-logo></brand-logo>
            <hamburger-menu class="ml-auto"></hamburger-menu>
        </div>
        <main>
            <slot></slot>
        </main>
    </div>
</template>

<script>
    import BrandLogo from 'LayoutComponents/BrandLogo.vue';
    import AppModals from 'LayoutComponents/AppModals.vue';
    import HamburgerMenu from 'LayoutComponents/HamburgerMenu.vue';

    export default {
        components: { BrandLogo, HamburgerMenu, AppModals },
        props: ['title'],
        mounted () {
            this.updatePageTitle(this.title)
        },
        watch: {
            title (title) {
                this.updatePageTitle(title)
            }
        },
        methods: {
            updatePageTitle (title) {
                document.title = title ? `${title} | StoneBills` : `StoneBills`
            }
        },
    }
</script>

<style lang="scss">
    .layout {
        @screen md {
            max-width: 768px;
            margin-left: auto;
            margin-right: auto;
        }
        @screen lg {
            max-width: 992px;
            margin-left: auto;
            margin-right: auto;
        }
        @screen xl {
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }
    }
</style>