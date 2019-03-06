<template>
    <layout title="Dashboard">
        <div class="mt-12">
            <bill-card v-for="bill in bills" :key="bill.id" :initial-bill="bill" color="red" name="Electric" date="02/26/2019" cost="236.50" :recurring="true"></bill-card>
        </div>
    </layout>
</template>

<script>
    import BillCard from 'Components/BillCard.vue';

    export default {
        props: ['bills'],
        components: {
            BillCard
        },
    }
</script>