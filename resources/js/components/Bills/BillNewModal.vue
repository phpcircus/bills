<template>
    <div class="flex flex-col items-center justify-start w-full h-full">
        <div class="w-full h-full flex flex-col bg-white text-center border-red border-t-4 px-8 py-4 shadow-md">
            <h1 class="text-2xl text-grey-darkest pb-4">Add a Bill</h1>
            <form @submit.prevent="createBill()" method="POST" action="/bill" autocomplete="off">
                <!--Name Field-->
                <div class="mb-8">
                    <div class="flex w-4/5 justify-between py-1 mb-1">
                        <input v-model="form.name" class="w-full appearance-none bg-transparent border-b-2 border-blue-light text-grey-darkest p-1" type="text" placeholder="Stream Electric" name="name" id="name" aria-label="Name">
                    </div>
                    <label class="block w-4/5 text-grey-darkest text-left text-sm font-bold" for="name">
                        <span v-if="errors.name" class="text-red text-xs italic ml-2">{{ errors.name }}</span>
                        <span v-else class="text-sm text-grey-darkest">Bill Name/Provider</span>
                    </label>
                </div>

                <!--Amount Field-->
                <div class="mb-8">
                    <div class="flex w-4/5 justify-between py-1 mb-1">
                        <money v-model="form.amount" v-bind="money"  class="w-full appearance-none bg-transparent border-b-2 border-blue-light text-grey-darkest p-1"></money>
                    </div>
                    <label class="block w-4/5 text-grey-darkest text-left text-sm font-bold" for="amount">
                        <span v-if="errors.amount" class="text-red text-xs italic ml-2">{{ errors.amount }}</span>
                        <span v-else class="text-sm text-grey-darkest">Amount</span>
                    </label>
                </div>

                <!-- Due Date -->
                <div class="mb-8">
                    <div class="flex flex-col w-1/2 py-1 mb-1">
                        <flat-pickr class="w-full appearance-none bg-transparent border-b-2 border-blue-light text-grey-darkest p-1 mb-1" name="due" v-model="form.due" placeholder="Due date" :config="dateConfig"></flat-pickr>
                        <label class="block w-4/5 text-grey-darkest text-left text-sm font-bold" for="due">
                            <span v-if="errors.due" class="text-red text-xs italic ml-2">{{ errors.due }}</span>
                            <span v-else class="text-sm text-grey-darkest">Due</span>
                        </label>
                    </div>
                </div>

                <!-- Recurring -->
                <div class="mb-8">
                    <span ref="parentToggle" @click.prevent.stop="toggleRecurring($event)" class="border rounded-full border-grey flex items-center cursor-pointer w-12 justify-start bg-grey-lightest mb-1">
                        <span class="rounded-full border w-6 h-6 border-grey shadow-inner bg-red shadow"></span>
                    </span>
                    <label class="block w-4/5 text-grey-darkest text-left text-sm font-bold">
                        <span class="text-sm text-grey-darkest">Recurring</span>
                    </label>
                </div>

                <!-- Recurring Period -->
                <div v-if="form.recurring" class="mb-8">
                    <v-select :options="periods" v-model="form.recurring_period" :searchable="false"></v-select>
                    <label class="block w-4/5 text-grey-darkest text-left text-sm font-bold">
                        <span v-if="errors.recurring_period" class="text-red text-xs italic ml-2">{{ errors.recurring_period }}</span>
                        <span class="text-sm text-grey-darkest">Recurring Period</span>
                    </label>
                </div>

                <!--Actions-->
                <div class="flex justify-between items-center mt-8 mb-8 w-4/5">
                    <button class="flex-none rounded-full bg-white text-blue font-bold py-2 px-4 border-2 border-blue hover:bg-blue hover:text-white hover:border-transparent mr-8" type="submit">
                        Create
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
    import flatPickr from 'vue-flatpickr-component';

    export default {
        components: { flatPickr, Money },
        data () {
            return {
                form: {
                    name: null,
                    amount: 0,
                    due: null,
                    recurring: false,
                    recurring_period: 'none',
                },
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
        methods: {
            createBill () {
                if (this.form.recurring == true && this.form.recurring_period == null) {
                    this.errors.recurring_period = 'You must chose a recurring period.';

                    return;
                }
                console.log('recurring: ', this.form.recurring);
                Bill.create(this.form);

                /* global Turbolinks */
                Turbolinks.visit('/');

            },
            toggleRecurring (e) {
                this.form.recurring = ! this.form.recurring;
                if (! this.form.recurring) {
                    this.form.recurring_period = null;
                }

                let parent = this.$refs.parentToggle;
                let child = parent.childNodes[0];

                child.classList.toggle('bg-green');
                parent.classList.toggle('justify-end');
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
</style>