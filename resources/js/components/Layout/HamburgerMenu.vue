<template>
    <div class="hamburger-menu-container">
        <button @click.prevent="toggleMenuDropdown()" class="hamburger-menu-button">
            <svg class="fill-current h-4 w-4" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Menu</title><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/></svg>
        </button>
        <ul v-if="showMenuDropdown" class="flex flex-col list-reset text-left w-48 border border-grey bg-grey-lightest shadow-md z-50 hamburger-menu">
            <li class="menu-item text-center h-8 cursor-pointer text-left h-16 leading-loose border-b border-grey-light hover:bg-green-light">
                <a href="/" class="w-full text-grey-darkest font-lato font-normal uppercase align-middle inline-block no-underline p-4">
                    <span class="inline-block">Dashboard</span>
                </a>
            </li>
            <li class="menu-item text-center h-8 cursor-pointer text-left h-16 leading-loose border-b border-grey-light hover:bg-green-light">
                <a @click.prevent="showNewBillModal()" href="#" class="w-full text-grey-darkest font-lato font-normal uppercase align-middle inline-block no-underline p-4">
                    <span class="inline-block">New Bill</span>
                </a>
            </li>
            <li class="menu-item text-center h-8 cursor-pointer text-left h-16 leading-loose border-b border-grey-light hover:bg-green-light">
                <a href="/summary" class="w-full text-grey-darkest font-lato font-normal uppercase align-middle inline-block no-underline p-4">
                    <span class="inline-block">Summary</span>
                </a>
            </li>
            <!-- <li class="menu-item text-center h-8 cursor-pointer text-left h-16 leading-loose border-b border-grey-light hover:bg-green-light">
                <a href="#" class="w-full text-grey-darkest font-lato font-normal uppercase align-middle inline-block no-underline p-4">
                    <span class="inline-block">Settings</span>
                </a>
            </li> -->
            <li class="menu-item text-center h-8 cursor-pointer text-left h-16 leading-loose border-b border-grey-light hover:bg-green-light">
                <a href="#" @click.prevent="doLogout()" class="w-full text-grey-darkest font-lato font-normal uppercase align-middle inline-block no-underline p-4">
                    <span class="inline-block">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                showMenuDropdown: false,
            }
        },
        methods: {
            toggleMenuDropdown () {
                this.showMenuDropdown = ! this.showMenuDropdown;
            },
            hideMenuDropdown () {
                this.toggleMenuDropdown();
            },
            doLogout () {
				axios.post('/logout').then( response => {
					this.redirectTo('/login');
				});
            },
            getCsrfToken () {
                let token = document.head.querySelector('meta[name="csrf-token"]');

                return token ? token.content : null;
            },
            redirectTo (url) {
                location.href = url;
            },
            showNewBillModal () {
                this.toggleMenuDropdown();
                this.$modal.show('new-bill');
            }
        }
    }
</script>

<style scoped lang="scss">
    .hamburger-menu-button {
        color: #22292f;
        z-index: 100;
    }
    .hamburger-menu {
        position: absolute;
        top: 48px;
        right: 10%;
    }
    .menu-item {
        &:hover {
            span {
                @apply .text-white;
            }
        }
    }
</style>