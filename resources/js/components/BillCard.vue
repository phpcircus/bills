<template>
    <div class="cardContainer relative overflow-hidden">
        <div ref="card" class="relative border-b border-grey-lightest">
            <div :id="`innerCard-${bill.id}`" ref="innerCard" class="innerCard p-4 bottom-shadow cursor-pointer" :class="[ getClass, { 'paid' : isPaid } ]">
                <div class="flex items-start relative h-120p">
                    <div class="flex flex-col h-full">
                        <h1 class="text-white text-xl lg:text-2xl font-semibold mb-2">
                            {{ bill.name }}
                        </h1>
                        <span v-if="bill.recurring" class="text-white text-sm font-normal mb-3">
                            Recurring {{ bill.recurring_period }}
                        </span>
                        <span v-else class="text-white text-sm font-normal mb-3">
                            One time payment
                        </span>
                        <div class="flex">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2 inline-block align-middle" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="3" stroke-linecap="square" stroke-linejoin="arcs"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                            <p class="text-white text-lg mb-2">
                                {{ bill.due_date }}
                            </p>
                        </div>
                    </div>
                    <div class="flex flex-col relative h-full ml-auto">
                        <div class="flex">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 inline-block align-middle" viewBox="0 0 24 24" fill="none" stroke="#FFF" stroke-width="3" stroke-linecap="square" stroke-linejoin="arcs"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                            <p class="text-white text-2xl font-semibold italic">
                                {{ bill.amount }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <transition name="slide">
            <div v-if="showOptions" class="flex w-full h-full absolute pin-t pin-l options-box">
                <div @click.prevent.stop="hideOptions()" class="flex justify-center items-center self-center h-full text-center w-1/4 bg-orange-dark p-4 cursor-pointer">
                    <span class="text-white text-lg font-semibold uppercase">Hide Options</span>
                </div>
                <div @click.prevent.stop="editBill()" class="flex justify-center items-center self-center h-full text-center w-1/4 bg-blue-dark p-4 cursor-pointer">
                    <span class="text-white text-lg font-semibold uppercase">Edit</span>
                </div>
                <div @click.prevent.stop="deleteBill()" class="flex justify-center items-center self-center relative h-full text-center w-1/4 bg-red-dark p-4 cursor-pointer">
                    <span v-if="! deleteBusy" class="text-white text-lg font-semibold uppercase">Delete</span>
                    <div v-else class="spinner">
                        <div class="rect1"></div>
                        <div class="rect2"></div>
                        <div class="rect3"></div>
                        <div class="rect4"></div>
                        <div class="rect5"></div>
                    </div>
                </div>
                <div @click.prevent.stop="markPaid()" class="flex justify-center items-center self-center relative h-full text-center w-1/4 bg-green-dark p-4 cursor-pointer">
                    <span v-if="! paidBusy" class="text-white text-lg font-semibold uppercase">Paid</span>
                    <div v-else class="spinner">
                        <div class="rect1"></div>
                        <div class="rect2"></div>
                        <div class="rect3"></div>
                        <div class="rect4"></div>
                        <div class="rect5"></div>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
    import Bill from 'Models/Bill';
    import ZingTouch from 'zingtouch';

    export default {
        props: {
            initialBill: Object,
        },
        data () {
            return {
                paid: false,
                bill: null,
                region: null,
                showOptions: false,
                paidBusy: false,
                deleteBusy: false,
                overdueCardClass: 'card-overdue',
                highCardClass: 'card-high',
                mediumCardClass: 'card-medium',
                lowCardClass: 'card-low',
            }
        },
        created () {
            this.bill = this.initialBill;
        },
        mounted () {
            const elem = document.getElementById('cards');
            this.region = new ZingTouch.Region(elem, false, false);

            this.region.bind(this.$refs.innerCard, 'tap', e => {
                this.toggleTranslateX(this.$refs.innerCard);
            }, false);
        },
        computed: {
            getClass () {
                let cardClass;

                switch (this.bill.severity) {
                    case 'overdue': cardClass = this.overdueCardClass;
                    break;

                    case 'high': cardClass = this.highCardClass;
                    break;

                    case 'medium': cardClass = this.mediumCardClass;
                    break;

                    case 'low': cardClass = this.lowCardClass;
                    break;

                    default:  cardClass = this.defaultCardClass;
                }

                return cardClass;
            },
            isPaid () {
                return this.paid;
            },
        },
        methods: {
            hideOptions () {
                this.toggleTranslateX(this.$refs.innerCard);
            },
            editBill () {
                this.$modal.show('edit-bill', {
                    bill: this.bill,
                });
            },
            deleteBill () {
                if (this.deleteBusy) return;
                this.deleteBusy = true;
                this.paid = ! this.paid;
                Bill.delete(this.bill.id);
            },
            markPaid () {
                if (this.paidBusy) return;
                this.paidBusy = true;
                this.paid = ! this.paid;

                if (this.paid) {
                    Bill.markPaid(this.bill);
                }
            },
            toggleTranslateX (elem) {
                if (elem.classList.contains('translatex')) {
                    this.showOptions = false;
                    elem.classList.remove('translatex');
                } else {
                    this.showOptions = true;
                    elem.classList.add('translatex');
                }
            }
        }
    }
</script>

<style scoped lang="scss">
    .innerCard {
        transition-timing-function: ease-in;
        transition: 0.3s;
    }
    .translatex {
        transform: translateX(100%);
        display: flex;
    }
    .paid {
        opacity: 0.4;
        background-image: linear-gradient(180deg,#8CB639, #9BCB41) !important;
    }
    .card-overdue {
        background-color: rgb(219, 52, 131);
        background-image: url("data:image/svg+xml,%3Csvg width='180' height='180' viewBox='0 0 180 180' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M82.42 180h-1.415L0 98.995v-2.827L6.167 90 0 83.833V81.004L81.005 0h2.827L90 6.167 96.167 0H98.996L180 81.005v2.827L173.833 90 180 96.167V98.996L98.995 180h-2.827L90 173.833 83.833 180H82.42zm0-1.414L1.413 97.58 8.994 90l-7.58-7.58L82.42 1.413 90 8.994l7.58-7.58 81.006 81.005-7.58 7.58 7.58 7.58-81.005 81.006-7.58-7.58-7.58 7.58zM175.196 0h-25.832c1.033 2.924 2.616 5.59 4.625 7.868C152.145 9.682 151 12.208 151 15c0 5.523 4.477 10 10 10 1.657 0 3 1.343 3 3v4h16V0h-4.803c.51.883.803 1.907.803 3 0 3.314-2.686 6-6 6s-6-2.686-6-6c0-1.093.292-2.117.803-3h10.394-13.685C161.18.938 161 1.948 161 3v4c-4.418 0-8 3.582-8 8s3.582 8 8 8c2.76 0 5 2.24 5 5v2h4v-4h2v4h4v-4h2v4h2V0h-4.803zm-15.783 0c-.27.954-.414 1.96-.414 3v2.2c-1.25.254-2.414.74-3.447 1.412-1.716-1.93-3.098-4.164-4.054-6.612h7.914zM180 17h-3l2.143-10H180v10zm-30.635 163c-.884-2.502-1.365-5.195-1.365-8 0-13.255 10.748-24 23.99-24H180v32h-30.635zm12.147 0c.5-1.416 1.345-2.67 2.434-3.66l-1.345-1.48c-1.498 1.364-2.62 3.136-3.186 5.14H151.5c-.97-2.48-1.5-5.177-1.5-8 0-12.15 9.84-22 22-22h8v30h-18.488zm13.685 0c-1.037-1.793-2.976-3-5.197-3-2.22 0-4.16 1.207-5.197 3h10.394zM0 148h8.01C21.26 148 32 158.742 32 172c0 2.805-.48 5.498-1.366 8H0v-32zm0 2h8c12.15 0 22 9.847 22 22 0 2.822-.53 5.52-1.5 8h-7.914c-.567-2.004-1.688-3.776-3.187-5.14l-1.346 1.48c1.09.99 1.933 2.244 2.434 3.66H0v-30zm15.197 30c-1.037-1.793-2.976-3-5.197-3-2.22 0-4.16 1.207-5.197 3h10.394zM0 32h16v-4c0-1.657 1.343-3 3-3 5.523 0 10-4.477 10-10 0-2.794-1.145-5.32-2.992-7.134C28.018 5.586 29.6 2.924 30.634 0H0v32zm0-2h2v-4h2v4h4v-4h2v4h4v-2c0-2.76 2.24-5 5-5 4.418 0 8-3.582 8-8s-3.582-8-8-8V3c0-1.052-.18-2.062-.512-3H0v30zM28.5 0c-.954 2.448-2.335 4.683-4.05 6.613-1.035-.672-2.2-1.16-3.45-1.413V3c0-1.04-.144-2.046-.414-3H28.5zM0 17h3L.857 7H0v10zM15.197 0c.51.883.803 1.907.803 3 0 3.314-2.686 6-6 6S4 6.314 4 3c0-1.093.292-2.117.803-3h10.394zM109 115c-1.657 0-3 1.343-3 3v4H74v-4c0-1.657-1.343-3-3-3-5.523 0-10-4.477-10-10 0-2.793 1.145-5.318 2.99-7.132C60.262 93.638 58 88.084 58 82c0-13.255 10.748-24 23.99-24h16.02C111.26 58 122 68.742 122 82c0 6.082-2.263 11.636-5.992 15.866C117.855 99.68 119 102.206 119 105c0 5.523-4.477 10-10 10zm0-2c-2.76 0-5 2.24-5 5v2h-4v-4h-2v4h-4v-4h-2v4h-4v-4h-2v4h-4v-4h-2v4h-4v-2c0-2.76-2.24-5-5-5-4.418 0-8-3.582-8-8s3.582-8 8-8v-4c0-2.64 1.136-5.013 2.946-6.66L72.6 84.86C70.39 86.874 69 89.775 69 93v2.2c-1.25.254-2.414.74-3.447 1.412C62.098 92.727 60 87.61 60 82c0-12.15 9.84-22 22-22h16c12.15 0 22 9.847 22 22 0 5.61-2.097 10.728-5.55 14.613-1.035-.672-2.2-1.16-3.45-1.413V93c0-3.226-1.39-6.127-3.6-8.14l-1.346 1.48C107.864 87.987 109 90.36 109 93v4c4.418 0 8 3.582 8 8s-3.582 8-8 8zM90.857 97L93 107h-6l2.143-10h1.714zM80 99c3.314 0 6-2.686 6-6s-2.686-6-6-6-6 2.686-6 6 2.686 6 6 6zm20 0c3.314 0 6-2.686 6-6s-2.686-6-6-6-6 2.686-6 6 2.686 6 6 6z' fill='%23dba0bc' fill-opacity='0.1' fill-rule='evenodd'/%3E%3C/svg%3E");
    }
    .card-high {
        background-color: rgb(231, 89, 23);
        background-image: url("data:image/svg+xml,%3Csvg width='64' height='64' viewBox='0 0 64 64' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M8 16c4.418 0 8-3.582 8-8s-3.582-8-8-8-8 3.582-8 8 3.582 8 8 8zm0-2c3.314 0 6-2.686 6-6s-2.686-6-6-6-6 2.686-6 6 2.686 6 6 6zm33.414-6l5.95-5.95L45.95.636 40 6.586 34.05.636 32.636 2.05 38.586 8l-5.95 5.95 1.414 1.414L40 9.414l5.95 5.95 1.414-1.414L41.414 8zM40 48c4.418 0 8-3.582 8-8s-3.582-8-8-8-8 3.582-8 8 3.582 8 8 8zm0-2c3.314 0 6-2.686 6-6s-2.686-6-6-6-6 2.686-6 6 2.686 6 6 6zM9.414 40l5.95-5.95-1.414-1.414L8 38.586l-5.95-5.95L.636 34.05 6.586 40l-5.95 5.95 1.414 1.414L8 41.414l5.95 5.95 1.414-1.414L9.414 40z' fill='%23eac1ad' fill-opacity='0.1' fill-rule='evenodd'/%3E%3C/svg%3E");
    }
    .card-medium {
        background-color: rgb(235, 153, 17);
        background-image: url("data:image/svg+xml,%3Csvg width='40' height='1' viewBox='0 0 40 1' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M0 0h20v1H0z' fill='%23eacb97' fill-opacity='0.1' fill-rule='evenodd'/%3E%3C/svg%3E");
    }
    .card-low {
        background-color: rgb(70, 165, 38);
        background-image: url("data:image/svg+xml,%3Csvg width='84' height='48' viewBox='0 0 84 48' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M0 0h12v6H0V0zm28 8h12v6H28V8zm14-8h12v6H42V0zm14 0h12v6H56V0zm0 8h12v6H56V8zM42 8h12v6H42V8zm0 16h12v6H42v-6zm14-8h12v6H56v-6zm14 0h12v6H70v-6zm0-16h12v6H70V0zM28 32h12v6H28v-6zM14 16h12v6H14v-6zM0 24h12v6H0v-6zm0 8h12v6H0v-6zm14 0h12v6H14v-6zm14 8h12v6H28v-6zm-14 0h12v6H14v-6zm28 0h12v6H42v-6zm14-8h12v6H56v-6zm0-8h12v6H56v-6zm14 8h12v6H70v-6zm0 8h12v6H70v-6zM14 24h12v6H14v-6zm14-8h12v6H28v-6zM14 8h12v6H14V8zM0 8h12v6H0V8z' fill='%23bace94' fill-opacity='0.1' fill-rule='evenodd'/%3E%3C/svg%3E");
    }
    .slide-enter-active {
        transition: all .3s ease;
    }
    .slide-leave-active {
            transition: all .3s ease;
    }
    .slide-enter, .slide-leave-to {
        transform: translateX(-100%);
    }
    .spinner {
        position: absolute;
        top: calc(-50% + 30px);
        left: calc(50% - 30px);
        margin: 100px auto;
        width: 50px;
        height: 40px;
        text-align: center;
        font-size: 10px;
    }

    .spinner > div {
        background-color: #fff;
        height: 100%;
        width: 6px;
        display: inline-block;
        -webkit-animation: sk-stretchdelay 1.2s infinite ease-in-out;
        animation: sk-stretchdelay 1.2s infinite ease-in-out;
    }

    .spinner .rect2 {
        -webkit-animation-delay: -1.1s;
        animation-delay: -1.1s;
    }

    .spinner .rect3 {
        -webkit-animation-delay: -1.0s;
        animation-delay: -1.0s;
    }

    .spinner .rect4 {
        -webkit-animation-delay: -0.9s;
        animation-delay: -0.9s;
    }

    .spinner .rect5 {
        -webkit-animation-delay: -0.8s;
        animation-delay: -0.8s;
    }

    @-webkit-keyframes sk-stretchdelay {
        0%, 40%, 100% {
            -webkit-transform: scaleY(0.4)
        }
        20% {
            -webkit-transform: scaleY(1.0)
        }
    }

    @keyframes sk-stretchdelay {
        0%, 40%, 100% {
            transform: scaleY(0.4);
            -webkit-transform: scaleY(0.4);
        }  20% {
            transform: scaleY(1.0);
            -webkit-transform: scaleY(1.0);
        }
    }
</style>