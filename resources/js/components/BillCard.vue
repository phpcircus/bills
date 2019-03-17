<template>
    <div class="cardContainer relative overflow-hidden">
        <div ref="card" class="relative">
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
                <div @click.prevent.stop="deleteBill()" class="flex justify-center items-center self-center h-full text-center w-1/4 bg-red-dark p-4 cursor-pointer">
                    <span class="text-white text-lg font-semibold uppercase">Delete</span>
                </div>
                <div @click.prevent.stop="togglePaid()" class="flex justify-center items-center self-center h-full text-center w-1/4 bg-green-dark p-4 cursor-pointer">
                    <span class="text-white text-lg font-semibold uppercase">Paid</span>
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
            this.region = new ZingTouch.Region(elem);

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
                console.log(`Deleting bill.`);
            },
            togglePaid () {
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
        background-image: linear-gradient(180deg,rgb(190, 34, 99),rgb(219, 52, 131));
    }
    .card-high {
        background-image: linear-gradient(180deg,rgb(168, 69, 22),rgb(231, 89, 23));
    }
    .card-medium {
        background-image: linear-gradient(180deg,rgb(205, 125, 14),rgb(235, 153, 17));
    }
    .card-low {
        background-image: linear-gradient(180deg,rgb(140, 182, 57), rgb(155, 203, 65));
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
</style>