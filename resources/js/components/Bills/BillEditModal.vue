<template>
    <div class="flex flex-col items-center justify-start w-full h-auto overflow-visible">
        <div class="w-full h-auto flex flex-col bg-white text-center border-red border-t-4 px-8 py-4 shadow-md overflow-visible">
            <h1 class="text-2xl text-grey-darkest pb-4">Edit Bill</h1>
            <form @submit.prevent="updateBill()" method="POST" action="#" autocomplete="off">
                <!--Name Field-->
                <div class="mb-8">
                    <div class="flex w-4/5 justify-between py-1 mb-1">
                        <input v-model="bill.name" class="w-full appearance-none bg-transparent border-b-2 border-blue-light text-grey-darkest p-1" type="text" placeholder="Stream Electric" name="name" id="name" aria-label="Name">
                    </div>
                    <label class="block w-4/5 text-grey-darkest text-left text-sm font-bold" for="name">
                        <span v-if="errors.name" class="text-red text-xs italic ml-2">{{ errors.name }}</span>
                        <span v-else class="text-sm text-grey-darkest">Bill Name/Provider</span>
                    </label>
                </div>

                <!--Amount Field-->
                <div class="mb-8">
                    <div class="flex w-4/5 justify-between py-1 mb-1">
                        <money v-model="bill.amount" v-bind="money"  class="w-full appearance-none bg-transparent border-b-2 border-blue-light text-grey-darkest p-1"></money>
                    </div>
                    <label class="block w-4/5 text-grey-darkest text-left text-sm font-bold" for="amount">
                        <span v-if="errors.amount" class="text-red text-xs italic ml-2">{{ errors.amount }}</span>
                        <span v-else class="text-sm text-grey-darkest">Amount</span>
                    </label>
                </div>

                <!-- Due Date -->
                <div class="mb-8">
                    <div class="flex flex-col w-1/2 py-1 mb-1">
                        <flat-pickr class="w-full appearance-none bg-transparent border-b-2 border-blue-light text-grey-darkest p-1 mb-1" name="due" v-model="bill.due" placeholder="Due date" :config="dateConfig"></flat-pickr>
                        <label class="block w-4/5 text-grey-darkest text-left text-sm font-bold" for="due">
                            <span v-if="errors.due" class="text-red text-xs italic ml-2">{{ errors.due }}</span>
                            <span v-else class="text-sm text-grey-darkest">Due</span>
                        </label>
                    </div>
                </div>

                <!-- Recurring -->
                <div class="mb-8">
                    <span ref="parentToggle" @click.prevent.stop="toggleRecurring($event)" class="border rounded-full border-grey flex items-center cursor-pointer w-12 justify-start bg-grey-lightest mb-1" :class="{ parentToggleActive: isRecurring }">
                        <span class="rounded-full border w-6 h-6 border-grey shadow-inner bg-red shadow" :class="{ childToggleActive: isRecurring }"></span>
                    </span>
                    <label class="block w-4/5 text-grey-darkest text-left text-sm font-bold">
                        <span class="text-sm text-grey-darkest">Recurring</span>
                    </label>
                </div>

                <!-- Recurring Period -->
                <div v-if="form.recurring" class="mb-8 overflow-visible">
                    <multiselect v-model="form.recurring_period"
                                 :options="periods"
                                 :searchable="false"
                                 :show-labels="false"
                                 :close-on-select="true"
                                 open-direction="top"
                                 placeholder="Choose period..."
                                 class="mb-1"></multiselect>
                    <label class="block w-4/5 text-grey-darkest text-left text-sm font-bold">
                        <span v-if="errors.recurring_period" class="text-red text-xs italic ml-2">{{ errors.recurring_period }}</span>
                        <span class="text-sm text-grey-darkest">Recurring Period</span>
                    </label>
                </div>
                <div class="flex mb-8">
                    <label class="block text-grey-dark font-bold">
                        <input class="mr-2 leading-tight" type="checkbox" v-model="editAll">
                        <span class="text-sm">
                            Edit all bills in this series?
                        </span>
                    </label>
                </div>

                <!--Actions-->
                <div class="flex justify-between items-center mt-8 mb-8 w-4/5">
                    <button class="flex-none rounded-full bg-white text-blue font-bold py-2 px-4 border-2 border-blue hover:bg-blue hover:text-white hover:border-transparent mr-8" type="submit">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import { Money } from 'v-money';
    import Bill from 'Models/Bill';
    import 'flatpickr/dist/flatpickr.css';
    import Multiselect from 'vue-multiselect';
    import flatPickr from 'vue-flatpickr-component';

    export default {
        props: ['bill'],
        components: { flatPickr, Multiselect, Money },
        data () {
            return {
                form: null,
                editAll: false,
                periods: [
                    'weekly', 'bi-weekly', 'monthly', 'bi-monthly',
                ],
                errors: [],
                dateConfig: {
                    dateFormat: 'Y-m-d',
                    altInput: true,
                    altFormat: 'm/d/Y',
                },
                money: {
                    decimal: '.',
                    thousands: ',',
                    prefix: '$ ',
                    suffix: '',
                    precision: 2,
                    masked: false
                },
            }
        },
        computed: {
            isRecurring () {
                return this.bill.recurring;
            }
        },
        created () {
            this.form = this.bill;

        },
        methods: {
            updateBill () {
                if (this.form.recurring == true && this.form.recurring_period == null) {
                    this.errors.recurring_period = 'You must chose a recurring period.';

                    return;
                }
                Bill.update(this.form, this.editAll);

                /* global Turbolinks */
                Turbolinks.visit('/');

            },
            toggleRecurring () {
                this.form.recurring = ! this.form.recurring;

                if (! this.form.recurring) {
                    this.form.recurring_period = null;
                }
            },
            resetForm () {
                this.form.name = null;
                this.form.amount = null;
                this.form.due = null;
                this.form.recurring_period = null;
                if (this.form.recurring) {
                    this.toggleRecurring();
                }
            }
        }
    }
</script>

<style>
    .modal-content {
        width: 40%;
        max-width: 600px;
    }
    .parentToggleActive {
        @apply .justify-end;
    }
    .childToggleActive {
        @apply .bg-green;
    }
</style>