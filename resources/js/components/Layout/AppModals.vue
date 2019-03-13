<template>
    <div>
        <modal-component name="new-bill" width="60%" :maxWidth="600" :adaptive="true" height="auto" class="text-center center">
            <bill-new-modal></bill-new-modal>
        </modal-component>
        <modal-component name="edit-bill" width="80%" :maxWidth="1000" :adaptive="true" :delay="250" height="auto" class="text-center center" @before-open="beforeOpenEditBill($event)">
            <bill-edit-modal :bill="bill"></bill-edit-modal>
        </modal-component>
    </div>
</template>

<script>
    import BillNewModal from 'Components/Bills/BillNewModal.vue';
    import BillEditModal from 'Components/Bills/BillEditModal.vue';

    export default {
        components: { BillNewModal, BillEditModal },
        data () {
            return {
                bill: null,
            }
        },
        methods: {
            beforeOpenEditBill (event) {
                this.bill = event.params.bill;
            }
        }
    }
</script>

<style>
    .v--modal-overlay[data-modal="new-bill"] .v--modal-box.v--modal {
        opacity: 1;
        overflow: visible;
    }
</style>