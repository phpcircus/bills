<template>
    <div class="container mx-auto">
        <app-modals></app-modals>
        <vue-snotify></vue-snotify>
        <div class="flex w-full py-4">
            <brand-logo></brand-logo>
            <hamburger-menu class="ml-auto"></hamburger-menu>
        </div>
        <main>
            <slot></slot>
        </main>
    </div>
</template>

<script>
    import AppModals from 'LayoutComponents/AppModals.vue';
    import BrandLogo from 'LayoutComponents/BrandLogo.vue';
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