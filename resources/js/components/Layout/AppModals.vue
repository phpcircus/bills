<template>
    <modal-component name="new-bill" width="60%" :maxWidth="600" :adaptive="true" height="auto" class="text-center center">
        <bill-new-modal></bill-new-modal>
    </modal-component>
</template>

<script>
    import BillNewModal from 'Components/Bills/BillNewModal.vue';

    export default {
        components: { BillNewModal }
    }
</script>

<style>
.v--modal-overlay[data-modal="new-bill"] .v--modal-box.v--modal {
    opacity: 1;
    overflow: visible;
}
</style>