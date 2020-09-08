<template functional>

    <div v-if="props.value" class="loader-circle text-center my-auto" >
        <v-progress-circular
            class="mx-auto"
            color="primary"
            indeterminate
            size="64"
        />
    </div>

</template>

<script>
export default {
    name: "BaseLoader",
    props: {
        value: {
            type: Boolean,
            default: true
        }
    },

}
</script>

<style scoped lang="scss">
    .loader-circle{
        position: absolute;
        left: calc(50% - 32px);
        top: calc(50% - 32px);
    }

</style>
