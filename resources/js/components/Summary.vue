<template>
    <layout title="Summary">
        <div class="container mx-auto mt-8">
            <div class="bg-white shadow rounded pt-6 pb-8 mb-4 flex flex-col border-t-4 border-red w-full">
                <div class="w-full flex bg-red mb-4 leading-tight title-bar">
                    <span class="bg-white w-12 h-12 rounded-lg mt-1 ml-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#E3342F" stroke-width="3" stroke-linecap="square" stroke-linejoin="arcs"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                    </span>
                    <h1 class="text-lg text-white px-6 pt-4"><span class="mr-4">Overdue:</span>{{ data['overdue']['total'] }}</h1>
                </div>
                <div class="flex justify-between items-center text-left px-8 py-1 mb-2">
                    <span class="flex-1 font-normal text-base text-red hover:text-red-light">Name</span>
                    <span class="flex-1 font-normal text-base text-red hover:text-red-light">Amount</span>
                    <span class="flex-1 font-normal text-base text-red hover:text-red-light">Due</span>
                </div>
                <div v-for="bill in data['overdue']['bills']" class="flex justify-between items-center text-left px-8 py-1 mb-2" :key="bill.id">
                    <span class="flex-1 font-normal text-base text-red hover:text-red-light">{{ bill['name'] }}</span>
                    <span class="flex-1 font-normal text-base text-red hover:text-red-light">{{ bill['amount'] }}</span>
                    <span class="flex-1 font-normal text-base text-red hover:text-red-light">{{ bill['due_date'] }}</span>
                </div>
            </div>
        </div>
        <div class="container mx-auto mt-8">
            <div class="bg-white shadow rounded pt-6 pb-8 mb-4 flex flex-col border-t-4 border-orange w-full">
                <div class="w-full flex bg-orange mb-4 leading-tight title-bar">
                    <span class="bg-white w-12 h-12 rounded-lg mt-1 ml-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#F6993F" stroke-width="3" stroke-linecap="square" stroke-linejoin="arcs"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                    </span>
                    <h1 class="text-lg text-white px-6 pt-4"><span class="mr-4">Due within one week:</span>{{ data['week']['total'] }}</h1>
                </div>
                <div class="flex justify-between items-center text-left px-8 py-1 mb-2">
                    <span class="flex-1 font-normal text-base text-orange hover:text-orange-light">Name</span>
                    <span class="flex-1 font-normal text-base text-orange hover:text-orange-light">Amount</span>
                    <span class="flex-1 font-normal text-base text-orange hover:text-orange-light">Due</span>
                </div>
                <div v-for="bill in data['week']['bills']" class="flex justify-between items-center text-left px-8 py-1 mb-2" :key="bill.id">
                    <span class="flex-1 font-normal text-base text-orange hover:text-orange-light">{{ bill['name'] }}</span>
                    <span class="flex-1 font-normal text-base text-orange hover:text-orange-light">{{ bill['amount'] }}</span>
                    <span class="flex-1 font-normal text-base text-orange hover:text-orange-light">{{ bill['due_date'] }}</span>
                </div>
            </div>
        </div>
    </layout>
</template>

<script>
    export default {
        props: ['data'],
    }
</script>

<style>
    .title-bar {
        height: 56px;
    }
</style>