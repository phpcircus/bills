<template>
    <div @click.prevent="toggleOptionsDropdown()" class="card p-4 bottom-shadow cursor-pointer" :class="[ getClass, { 'paid' : isPaid } ]">
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
                <div class="flex mt-auto">
                    <span class="text-xl text-white mr-2">PAID: </span>
                    <span @click.prevent.stop="togglePaid($event)" class="border rounded-full border-grey flex items-center cursor-pointer w-12 justify-start bg-grey-lightest">
                        <span class="rounded-full border w-6 h-6 border-grey shadow-inner shadow paid-toggle"></span>
                    </span>
                </div>
            </div>
            <ul v-if="showOptionsDropdown" class="flex flex-col list-reset text-left w-48 border border-grey bg-grey-lightest shadow-md z-50 options-menu">
                <li class="option-item text-center h-8 cursor-pointer text-left h-16 leading-loose border-b border-grey-light hover:bg-green-light">
                    <a href="#" @click.native="hideOptionsDropdown()" class="w-full text-grey-darkest font-lato font-normal uppercase align-middle inline-block no-underline p-4">
                        <span class="inline-block">Show Details</span>
                    </a>
                </li>
                <li class="option-item text-center h-8 cursor-pointer text-left h-16 leading-loose border-b border-grey-light hover:bg-green-light">
                    <a href="#" @click.prevent="editBill()" class="w-full text-grey-darkest font-lato font-normal uppercase align-middle inline-block no-underline p-4">
                        <span class="inline-block">Edit</span>
                    </a>
                </li>
                <li class="option-item text-center h-8 cursor-pointer text-left h-16 leading-loose border-b border-grey-light hover:bg-red-light">
                    <a href="#" @click.prevent="deleteBill()" class="w-full text-grey-darkest font-lato font-normal uppercase align-middle inline-block no-underline p-4">
                        <span class="inline-block">Delete</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    import Bill from 'Models/Bill';

    export default {
        props: {
            color: {
                type: String,
                required: true,
                default: 'red',
            },
            initialBill: Object,
        },
        data () {
            return {
                paid: false,
                showOptionsDropdown: false,
                bill: null,
            }
        },
        created () {
            this.bill = this.initialBill;
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
            overdueCardClass () {
                return 'card-overdue';
            },
            highCardClass () {
                return 'card-high';
            },
            mediumCardClass () {
                return 'card-medium';
            },
            lowCardClass () {
                return 'card-low';
            },
        },
        methods: {
            editBill () {
                this.toggleOptionsDropdown();
                this.$modal.show('edit-bill', {
                    bill: this.bill,
                });
            },
            deleteBill () {
                console.log(`Deleting bill.`);
            },
            togglePaid (e) {
                this.paid = ! this.paid;

                let parent = e.currentTarget;
                let child = parent.childNodes[0];

                child.classList.toggle('bg-green');
                parent.classList.toggle('justify-end');

                if (this.paid) {
                    Bill.markPaid(this.bill);
                }
            },
           toggleOptionsDropdown () {
                this.showOptionsDropdown = ! this.showOptionsDropdown;
            },
            hideOptionsDropdown () {
                this.toggleOptionsDropdown();
            }
        }
    }
</script>

<style scoped lang="scss">
    .paid-toggle {
        background: #C02365;
    }
    .card {
        z-index: -1;
    }
    .paid {
        opacity: 0.4;
        background-image: linear-gradient(180deg,#8CB639, #9BCB41) !important;
    }
    .options-menu {
        position: absolute;
        top: 24px;
        right: 48px;
    }
    .option-item {
        &:hover {
            span {
                color: white;
            }
        }
    }
    .card-overdue {
        background-image: linear-gradient(180deg,#BE2263,#DB3483);
    }
    .card-high {
        background-image: linear-gradient(180deg,#BD2162,#E03988);
    }
    .card-medium {
        background-image: linear-gradient(180deg,#CD7D0E,#EB9911);
    }
    .card-low {
        background-image: linear-gradient(180deg,#8CB639, #9BCB41);
    }
</style>