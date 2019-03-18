<template>
    <layout title="Dashboard">
        <div id="cards">
            <bill-card v-for="bill in bills" :key="bill.id" :initial-bill="bill"></bill-card>
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