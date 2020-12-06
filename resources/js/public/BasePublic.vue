<template>
    <layout-master v-bind="$attrs">
        <base-index/>
    </layout-master>
</template>

<script>
    import LayoutMaster from "./layout/LayoutMaster";
    import BaseIndex from "./index/BaseIndex";
    export default {
        name: "BasePublic",
        components: {BaseIndex, LayoutMaster},
        data() {
            return {}
        },
        props: {

        },
        computed: {},
        methods: {},
        mounted() {

        },
    }
</script>

<style scoped>

</style>
